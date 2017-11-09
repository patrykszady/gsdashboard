<?php

namespace App\Http\Controllers;

use App\User;
use App\Vendor;
use App\Project;
use App\Expense;
use App\Distribution;
use App\ExpenseSplit;

use Session;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreExpenseSplit;


class ExpenseSplitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Expense $expense)
    {
        //if $expense->receipt doesnt exist, redirect to expesnes.edit with error
        if($expense->receipt == null) {
            Session::flash('error', 'This expense needs a receipt to be split.');
            return redirect(route('expenses.edit', $expense->id));
        }
        //if expense already has splits send to Expensesplits Edit view
        if($expense->expense_splits()->count() > 0){
             return redirect(route('expensesplits.edit', $expense->id));
        }

        $expensesplit = true;
        $employees = User::employees()->orderBy('first_name', 'asc')->get();
        $primary_vendor = Vendor::findOrFail(Auth::user()->primary_vendor);
        $projects = Project::isActive();
        $distributions = Distribution::all();
        $vendors = Vendor::orderBy('business_name', 'asc')->get();

        return view('expensesplits.create', compact('projects', 'vendors', 'employees', 'primary_vendor', 'distributions', 'expense', 'expensesplit'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExpenseSplit $request)
    {
        //Save each expense_split
        $count = count($request->amount);
        for($i = 0; $i < $count; ++$i){
            $expense_split = new ExpenseSplit;
            $expense_split->amount = $request->amount[$i];
            if(is_numeric($request->project_id[$i])) {
                $expense_split->project_id = $request->project_id[$i];
            } else {
                $expense_split->distribution_id = preg_replace("/[^0-9]/","",$request->project_id[$i]);
            }
            $expense_split->reimbursment = $request->reimbursment[$i];
            $expense_split->note = $request->note[$i];
            $expense_split->created_by_user_id = Auth::id();
            $expense_split->expense_id = $request->expense_id;
            $expense_split->save();
        }

        $expense = Expense::findOrFail($request->expense_id);
        $expense->project_id = 0;
        $expense->distribution_id = 0;
        $expense->save();

        Session::flash('success', 'Splits were added to this receipt');
        
        return redirect(route('expenses.show', $request->expense_id));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ExpenseSplit  $expenseSplit
     * @return \Illuminate\Http\Response
     */
    public function show(ExpenseSplit $expenseSplit)
    {
        //shows in expenses.show together with expense info
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ExpenseSplit  $expenseSplit
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        $expense = Expense::where('id', $expense->id)->first();
        $expensesplit = true;
        $expense_splits = Expensesplit::where('expense_id', $expense->id)->get();
        $distributions = Distribution::all();
        $projects = Project::all();
        $vendors = Vendor::where('biz_type', 1)->orderBy('business_name', 'asc')->get();

        return view('expensesplits.edit', compact('expense', 'projects', 'vendors', 'distributions', 'expense_splits', 'expensesplit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ExpenseSplit  $expenseSplit
     * @return \Illuminate\Http\Response
     */
    public function update(StoreExpenseSplit $request, Expense $expense)
    {
        //if not in array, delete from database
        $split_ids = collect($request->expense_split_id);
        $splits = ExpenseSplit::where('expense_id', $expense->id)->get();
        /*dd($split_ids);*/
        foreach($splits as $split_id){
            if($split_ids->contains($split_id->id)){
                var_dump($split_id->id);
            } else {
                ExpenseSplit::where('id', $split_id->id)->delete();
            }
        }

        foreach($request->expense_split_id as $i => $expense_split){
            //if split doesn't exist yet..create new one
            if(is_null(ExpenseSplit::find($expense_split))) {
                $expense_split = new ExpenseSplit;
            //update expense_split->id
            } else {
                $expense_split = ExpenseSplit::findOrFail($expense_split);
                $expense_split->project_id = null;
                $expense_split->distribution_id = null;
            }

            $expense_split->amount = $request->amount[$i];
            if(is_numeric($request->project_id[$i])) {
                $expense_split->project_id = $request->project_id[$i];
            } else {
                $expense_split->distribution_id = preg_replace("/[^0-9]/","",$request->project_id[$i]);
            }              
            $expense_split->reimbursment = $request->reimbursment[$i];
            $expense_split->note = $request->note[$i];
            $expense_split->expense_id = $request->expense_id;
            $expense_split->created_by_user_id = Auth::id();
            $expense_split->save();         
        }

        Session::flash('success', 'Splits were added to this receipt');
        
        return redirect(route('expenses.show', $expense->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ExpenseSplit  $expenseSplit
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExpenseSplit $expenseSplit)
    {
        //
    }
}
