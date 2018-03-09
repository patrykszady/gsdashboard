<?php

namespace App\Http\Controllers;

use App\Distribution;
use App\Hour;
use App\Mail\Timesheets;
use App\Project;
use App\Expense;
use App\Vendor;
use App\User;
use App\Check;

use App\Http\Requests\StoreHourPayment;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreHour;

use Illuminate\Http\Request;
use URL;
use PDF;
use Mail;
use Session;
use Validator;

use Carbon\Carbon;
use Carbon\CarbonInterval;

class HourController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function printTimesheets()
    {
        $projects = Project::isActive();
        $days = $this->getWeek();

        $vendor = Vendor::findOrFail(1); //automatically get this and when to print from a new table in db
        $employees = User::whereIn('id', $vendor->users()->pluck('user_id'))->get();

        $pdf = PDF::loadView('hours.print', compact('employees', 'projects', 'days'))
                ->setPaper('a4')->setOrientation('landscape');
        $filename = 'Timesheets.' . date('Y-m-d-H-i-s') . '.pdf';
        
        $location = storage_path('files/timesheets/' . $filename);
        $pdf->save($location);
        $data = array(
            'pdf' => $location
            );

        Mail::send('hours._emailtimesheets', $data, function($message) use ($data)
        {
            $message->to('smm3281s8yq7j5@print.epsonconnect.com'); //put into database
            $message->subject('Week Timesheets');
            $message->from('patryk@gs.construction'); //put into database
            $message->attach($data['pdf']);
        });
     
        return back();
    }

    public function getMondays()
    {
        return new \DatePeriod(
            Carbon::parse("4 mondays ago"),
            CarbonInterval::week(),
            Carbon::parse("2 mondays from now")
        );
    }

    public function getWeek()
    {
        return new \DatePeriod(
            Carbon::parse("next monday"),
            CarbonInterval::day(),
            Carbon::parse("next monday")->addDays(6)
        );
    }

    public function hoursPayment($id)
    {
        if(URL::previous() == URL::current()) {

        } else {
            Session::put('takemeback', URL::previous()); 
        }

        $employees = User::employees()->orderBy('first_name', 'asc')->get();
        $user = User::findOrfail($id);
            //doesnthave
        $expenses = Expense::where('paid_by', $id)->where('check_id', '=', NULL)->get();
        $paid_by_hours = Hour::where('paid_by', $user->id)->where('check_id', NULL)->where('invoice', '!=', NULL)->get();
        $hours = Hour::where('user_id', $user->id)->where('check_id', '=', NULL)->where('invoice', '=', NULL)->get();


        $timesheets = Hour::where('user_id', $user->id)->UnpaidTimesheets()->get();

        return view('hours.hourspayment', compact('timesheets', 'user', 'expenses', 'hours', 'employees', 'paid_by_hours'));
    }

    public function storePayment(StoreHourPayment $request)
    {
    //if paid_by = 0, $hour->paid_by = Auth primary_vendor
    $count_expenses = isset($request->expense) ? count($request->expense) : 0;
    $count_hours = isset($request->hour) ? count($request->hour) : 0;
    $count_paid_by_hours = isset($request->paid_by_hour) ? count($request->paid_by_hour) : 0;

    //if both empty, do not create a new check. otherwise, make new check
    if($count_expenses == 0 and $count_hours == 0 and $count_paid_by_hours == 0){
        //return with error -- nothing selected/check # ____ is $0 // check has to be more than .01
    }elseif(isset($request->check)) {
        $check = new Check;
        $check->check = $request->check;
        $check->date = Carbon::parse($request->date)->toDateTimeString();
        $check->created_by_user_id = Auth::id();
        $check->save();
    }

    for($i = 0; $i < $count_expenses; ++$i){
        if($request->expense[$i] == null){

        } else {
        $expense = Expense::findOrfail($request->expense[$i]);
        $expense->check_id = $check->id;
        $expense->update();
        }       
    }      

    for($i = 0; $i < $count_paid_by_hours; ++$i){
        if($request->paid_by_hour[$i] == null){
        } else {
        $hour = Hour::findOrfail($request->paid_by_hour[$i]);
            if(isset($check)) {
                $hour->check_id = $check->id;
            }else{
            }
        
        $hour->update();
        }       
    }  
    for($i = 0; $i < $count_hours; ++$i){
        if($request->hour[$i] == null){

        } else {
        $hour = Hour::findOrfail($request->hour[$i]);
            if(isset($check)) {
                $hour->check_id = $check->id;
                $hour->paid_by = NULL;
            }elseif(isset($request->invoice)) {
                $hour->paid_by = $request->paid_by;
                $hour->invoice = $request->invoice;
            }
        
        $hour->update();
        }       
    }
        return redirect(Session::pull('takemeback'))->with('success', 'Payment was added');
    }
    /**m
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          /*  $checks = Expense::leftJoin('hours', 'expenses.check', '=', 'hours.check')->get();
            dd($checks);*/
        $hours = Hour::timesheets()->get();
/*        $checks = Expense::groupBy('check_id')->get();*/
/*        $hourss = Hour::unpaidTimesheets()->get();*/
        return view('hours.index', compact('hours'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mondays = $this->getMondays();

        $employees = User::employees()->with('hours')->get();

        $projects = Project::isActive(); // Project::active->get();
        return view('hours.create', compact('projects', 'employees', 'mondays'));
    }

    public function store(StoreHour $request)
    {
    //MOVE TO StoreHour..somehow, we need the opposite of Validate::exists
    $hour = Hour::where('user_id', $request->user_id)->where('date', $request->date)->get();
    
    if(isset($hour[0])) {
        $user = User::findOrfail($request->user_id);

        $errors = new \Illuminate\Support\MessageBag();

        // add your error messages: 
        // Edit link within this Error
        $errors->add('date', $user->first_name . ' already has a timesheet for week of ' . Carbon::parse($request->date)->toFormattedDateString(). '. Please edit it instead.');

        return back()->withErrors($errors)->withInput();

        
    } else {
    $count = count($request->hours);
        for($i = 0; $i < $count; ++$i){
            if($request->hours[$i] == null){

            } else {

            $hour = new Hour;
            $hour->amount = $request->hours[$i] * $request->hourly;
            $hour->hours = $request->hours[$i];
            $hour->project_id = $request->project_id[$i];
            $hour->hourly = $request->hourly;
            $hour->date = $request->date;
            $hour->user_id = $request->user_id; //Employee created for?
            $hour->created_by_user_id = Auth::id();
            $hour->note = $request->note;

            $hour->save();

            }
        }
    }
        return redirect(route('hours.index'))->with('success', 'Hours for ' . $hour->user->first_name . ' were added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Hour  $hour
     * @return \Illuminate\Http\Response
     */
    public function show(Hour $hour)
    {
        $timesheet = Hour::where('date', $hour->date)->where('user_id', $hour->user_id);
        $hours = $timesheet->get();

        
        $checks = $timesheet->where('check', '!=', null)->groupBy('check')->get();
        return view('hours.show',compact('hour', 'hours', 'checks'));
    }

/*    public function edit(Hour $hour)
    {

        $mondays = $this->getMondays();

        $hours = Hour::where('date', $hour->date)->where('user_id', $hour->user_id)->get();
     
        $employees = User::employees()->with('hours')->get();

        $projects = Project::all(); // Project::active->get();

        return view('hours.edit', compact('projects', 'employees', 'mondays', 'hour', 'hours'));
    }*/

    public function update(Request $request, Hour $hour)
    {
        //
    }

    public function destroy(Hour $hour)
    {
        //
    }

    
}
