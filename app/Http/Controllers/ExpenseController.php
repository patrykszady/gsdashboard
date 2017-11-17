<?php

namespace App\Http\Controllers;

use App\ExpenseSplit;
use App\Distribution;
use App\Expense;
use App\Project;
use App\Vendor;
use App\Client;
use App\Check;
use App\Hour;
use App\User;
use App\Http\Requests\StoreExpense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use URL;
use PDF;
use Image;
use Storage;
use Session;
use Response;
use Datatables;

use Carbon\Carbon;

class ExpenseController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => 'original_receipt']);
    }

    public function receipt($receipt)
    {
        $response = Image::make(storage_path('files/receipts/' . $receipt));
        $response = $response->resize(1000, null, function ($constraint) {
        $constraint->aspectRatio();
        })->response();

        return $response;
    }

    //Show full-size receipt to anyone with a link
    public function original_receipt($receipt)
    {
        $path = storage_path('files/receipts/' . $receipt);
        $response = Response::make(file_get_contents($path), 200, [
            'Content-Type' => 'application/pdf'
        ]);
        return $response;
    }

    //save all project reimbursments to a PDF
    public function printReimbursment(Project $project)
    {
        $expenses = $project->expenses()->get();
        $splits = $project->expenseSplits()->with('expense')->get();
        $expenses = $expenses->merge($splits);
        $expenses = $expenses->where('reimbursment', 'Client');

        $pdf = PDF::loadView('expenses.printReimbursment', compact('expenses'))
                ->setPaper('a4'); //->setOrientation('portrait')
        $filename = 'Reimbursment.' . date('Y-m-d-H-i-s') . '.pdf';
        
        $location = storage_path('reimbursments/' . $filename);
    
        return $pdf->stream($location, 'reimbursments.pdf');
        //QUEUE THIS??
    }

    public function index()
    {
        //$expense_input = auto added expenses with NO PROJECT
        $expense_input = Expense::notSplitnoProject()->count();
        $distributions = Distribution::all();
        $expenses = Expense::expenseWithSplits();
        
        return view('expenses.index', compact('expenses', 'distributions', 'expense_input'));
    }

    public function input()
    {
        $expenses = Expense::notSplitnoProject()->get();
        $employees = User::employees()->orderBy('first_name', 'asc')->get();
        $primary_vendor = Vendor::findOrFail(Auth::user()->primary_vendor);
        $projects = Project::isActive();
        $distributions = Distribution::all();
        $vendors = Vendor::orderBy('business_name', 'asc')->get();
        
        return view('expenses.input', compact('expenses', 'employees', 'primary_vendor', 'projects', 'distributions', 'vendors'));
    }

    public function inputStore(Request $request)
    {
    $count = count($request->project_id);
        for($i = 0; $i < $count; ++$i){
            if(!is_null($request->project_id[$i])){
                $expense = Expense::findOrfail($request->expense_id[$i]);
                if(is_numeric($request->project_id[$i])) {
                    $expense->project_id = $request->project_id[$i];
                } else {
                    $expense->distribution_id = preg_replace("/[^0-9]/","",$request->project_id[$i]);
                    $expense->project_id = NULL; //or nothing?
                }
                $expense->paid_by = $request->paid_by[$i];
                $expense->reimbursment = $request->reimbursment[$i];
                $expense->note = NULL;
            
                $expense->save();
            }       
        }
        return back();      
    }

    public function changechecks()
    {
        //foreach checks as check -> find expeses with check_id = check->check and change to $check-id

        $checks = Check::all();
        foreach ($checks as $check){
            foreach (Expense::where('check_id', $check->check)->get() as $expense){
                $expense->check_id = $check->id;
                $expense->save();
            }
        }
/*        $checks = Check::all();
        foreach ($checks as $check){
            foreach (Hour::where('check_id', $check->check)->get() as $hour){
                $hour->check_id = $check->id;
                $hour->save();
            }
        }*/
    }

    public function create()
    {
        //if url changed and come back, expenses and 'expense_refresh' remains. 'expense_refresh' always remains until session expires or DONE or Leaves
        if(Session::exists('expense_refresh')) {
            $time = Session::get('expense_refresh')->date;
            $expense = Expense::where('created_by_user_id', Auth::id())->where('created_at', '>', $time)->latest('created_at')->get();

            if($expense->count() < 1) {
                //$expenses = nothing, will not show in view
                //add $expense->id to array, carry the array over to $expense(s)::where...this will get rid of Session::expense_refresh.
                //git test
            } else {
                $expenses = $expense;
            }
        }

        if(URL::previous() == URL::current()) {

        } else {
            Session::pull('receipt_img');
            Session::put('takemeback', URL::previous());
            Session::put('expense_refresh', Carbon::now());
        }
        
        $employees = User::employees()->orderBy('first_name', 'asc')->get();
        $primary_vendor = Vendor::findOrFail(Auth::user()->primary_vendor);
        $projects = Project::isActive();
        $distributions = Distribution::all();
        $vendors = Vendor::orderBy('business_name', 'asc')->get();
        
        return view('expenses.create', compact('projects', 'vendors', 'employees', 'expenses', 'primary_vendor', 'distributions'));
    }

    public function store(StoreExpense $request)
    {
/*        //Check if Expense is existing
        if($request->has('duplicate')){

        } else {
            $existing = Expense::duplicate($request);

            if ($existing->exists()) {
                $existing_expense = $existing->first();
                return redirect()->back()->with('existing_expense', $existing_expense)->withInput();
            }
        }
*/
        $expense = Expense::create($request->except(['receipt', 'receipt_img', 'check_id', 'duplicate', 'project_id']));

        //If Check isset and Check # exists in database
        $check = Check::where('check', $request->check_id)->first();

        //no check entered..do nothing
        if(is_null($request->check_id)) {
        
        //check exists and $check exists
        } elseif(!is_null($request->check_id) and $check != null) {
            $check = Check::findOrFail($check->id);
            $expense->check_id = $check->id;

        //Create new check
        } else {
            $check = new Check;
            $check->check = $request->check_id;
            $check->date = $expense->expense_date;
            $check->created_by_user_id = Auth::id();
            $check->save();

            $expense->check_id = $check->id;
        }

        if($request->project_id == 0 AND is_numeric($request->project_id)) {
            $expense->project_id = $request->project_id;
            $expense->distribution_id = 0;
        } elseif(is_numeric($request->project_id)) {
            $expense->project_id = $request->project_id;
        } else {
            $expense->distribution_id = preg_replace("/[^0-9]/","",$request->project_id);
        }

        if(Session::exists('receipt_img')) {
            $expense->receipt = Session::pull('receipt_img');
        }
        $expense->created_by_user_id = Auth::id(); //who created this expense
        
        $expense->save();

        Session::flash('success', 'Expense for $' . $expense->amount . ' was created.');

        if($expense->project_id == 0 AND is_numeric($request->project_id)){
             return redirect(route('expensesplits.create', $expense->id));
        }

        if($request->has('another')) {
            return redirect(route('expenses.create')); 
        } elseif($request->has('done')) {
            Session::forget('expense_refresh');
            return redirect(Session::pull('takemeback'));
        } else {
            Session::forget('expense_refresh');
            return redirect(route('expenses.index'));
        }        

    }

    public function show(Expense $expense)
    {
        $distribution = Distribution::where('id', preg_replace("/[^0-9]/","",$expense->project_id))->first();
        $expense_splits = ExpenseSplit::where('expense_id', $expense->id)->get();
        
        return view('expenses.show', compact('expense', 'distribution', 'expense_splits'));
    }

    public function edit(Expense $expense)
    {
        if(URL::previous() == URL::current()) {
        } else {
            Session::put('takemeback', URL::previous());
        }

        $expense_splits = ExpenseSplit::where('expense_id', $expense->id)->get();
        $distributions = Distribution::all();
        $employees = User::employees()->get();
        $primary_vendor = Vendor::findOrFail(Auth::user()->primary_vendor);
        //CHANGE TO Active Projects
        $projects = Project::all();
        $vendors = Vendor::orderBy('business_name', 'asc')->get();

        return view('expenses.edit', compact('expense', 'projects', 'vendors','employees', 'primary_vendor', 'distributions', 'expense_splits'));
    }

    public function update(StoreExpense $request, Expense $expense)
    {
        $check = Check::where('check', $request->check_id)->first();
        //no check entered/check is empty AND $expense->check_id is set before update
        if(is_null($request->check_id) and isset($expense->check_id)) {
            //if this expense was the only one attached to check, destroy check on Checks table..if others exist, leave.
            if(Expense::where('check_id', $expense->check_id)->count() >= 1) {
                //destroy check entry
                $check = Check::where('check', $expense->check_id)->first()->delete();
            }
            $expense->check_id = null;
        //If Check isset and Check # exists in database
        } elseif(!is_null($request->check_id) and $check != null) {
            $expense->check_id = $check->check;
        } elseif (!is_null($request->check_id)) {
            //Create new check
            $check = new Check;
            $check->check = $request->check_id;
            $check->date = $expense->expense_date;
            $check->created_by_user_id = Auth::id();
            $check->save();

            $expense->check_id = $check->check;
        }

        //replacing existing receipt file
        if ($request->hasFile('receipt') and isset($expense->receipt)) {
            $oldFilename = $expense->receipt;
            $expense->receipt = Session::pull('receipt_img');
            Storage::delete('receipts/' . $oldFilename);
        } elseif ($request->hasFile('receipt')) {
            $expense->receipt = Session::pull('receipt_img');
        } elseif (Session::has('receipt_img')) {
            $expense->receipt = Session::pull('receipt_img');
        }

        $expense->created_by_user_id = Auth::id();
        
        if(is_numeric($request->project_id)) {
            $expense->project_id = $request->project_id;
            $expense->distribution_id = null;
        } else {
            $expense->distribution_id = preg_replace("/[^0-9]/","",$request->project_id);
            $expense->project_id = null;
        }
        $expense->save();
        $expense->update($request->except(['receipt', 'receipt_img', 'check_id', 'expense_id', 'project_id', 'distribution_id']));

        $expense->save();

        Session::flash('success', 'Expense for $' . $expense->amount . ' was edited.');
        if($expense->project_id == 0 AND $expense->distribution_id == NULL){
            return redirect(route('expensesplits.create', $expense->id));
        }

        if($request->has('update')) {
            return redirect(Session::pull('takemeback'));
        } else {
            return redirect(route('expenses.index'));
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        //if this expense was the only one attached to check, destroy check on Checks table..if others exist, leave.
        $count = Expense::where('check_id', $expense->check_id)->count();
        $count1 = Hour::where('check_id', $expense->check_id)->count();

        //destroy check entry if it's the only one
        if($count <= 1 and $count1 == 0){
            $check = Check::where('check', $expense->check_id)->first()->delete();
        }else {
            return redirect()->back()->with('error', 'Cant delete expense that had a check paid already');
        }   
        //destry receipt assoicated with expense
        if (isset($expense->receipt)) {
            Storage::delete('receipts/' . $expense->receipt);
        }
        //destroy any splits associated with this expense
        ExpenseSplit::where('expense_id', $expense->id)->delete();

        //finally...delete the expense
        Expense::destroy($expense->id);  

        return redirect(route('expenses.index'))->with('success', 'Expense was deleted.');
    }

  /*  public function carbon()
    {

        $c = new Carbon('-2 days');

        echo $c->toDateTimeString();

        die();
    }*/
}
