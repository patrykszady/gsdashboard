<?php

namespace App\Http\Controllers;

use App\ExpenseSplit;
use App\Projectstatus;
use App\Distribution;
use App\Expense;
use App\Project;
use App\Vendor;
use App\Check;
use App\Hour;
use App\User;
use App\Bid;
use Illuminate\Http\Request;

use App\Http\Requests\StoreVendor;
use App\Http\Requests\StoreVendorPayment;
use Illuminate\Support\Facades\Auth;

use Session;
use Carbon\Carbon;
use URL;

class VendorController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function vendorPayment(Vendor $vendor)
    {   
        //Doesn't put a new 'takemeback' into the Session If url is this ('users.edit')
        if(URL::previous() == URL::current()) {
        //save last URL so when form is submitted i can be taken back ("intended")...eventually ends up in a Middleware        
        } else {
            Session::put('takemeback', URL::previous()); 
        }
        
      /*  $projects = Project::isActive(); */
       /* $projects = $vendor->projects()->distinct()->get(); //projects with balance that belong to this vendor*/
        $projects = Project::all(); //projects with balance that belong to this vendor*/
        $employees = User::employees()->orderBy('first_name', 'asc')->get();
        $expenses = Expense::where('vendor_id', $vendor->id)->get();
        $expensess = Expense::where('paid_by', 'V:' . $vendor->id)->where('check_id', NULL)->get();
        $expensesss = Expense::where('reimbursment', $vendor->id)->where('check_id', NULL)->get();
        $bids = Bid::where('vendor_id', $vendor->id)->get();
        return view('vendors.payment', compact('vendor', 'expenses', 'projects', 'bids', 'expensess', 'expensesss', 'employees'));
    }

    public function vendorStorePayment(StoreVendorPayment $request)
    {
    //create check
    if($request->check_id != null) {
        $check = new Check;
        $check->check = $request->check_id;
        $check->date = Carbon::parse($request->date)->toDateTimeString(); //why not just $request->date
        $check->created_by_user_id = Auth::id();
        $check->save();
    }

    $count = count($request->expense);
    for($i = 0; $i < $count; ++$i){
        if($request->expense[$i] == null){

        } else {
        $expense = Expense::findOrFail($request->expense[$i]);
        $expense->check_id = $check->id;
        $expense->created_by_user_id = Auth::id();
        $expense->save();
        }       
    }
    //incoporate into ExpenseSplit??
    $count = count($request->expense_by_primary_vendor);
    for($i = 0; $i < $count; ++$i){
        if($request->expense_by_primary_vendor[$i] == null){

        } else {
        $old_expense = Expense::findOrFail($request->expense_by_primary_vendor[$i]);
        $expense = new Expense;
        $expense->project_id = $old_expense->project_id;
        $expense->distribution_id = $old_expense->distribution_id;
        $expense->check_id = $check->id;
        $expense->created_by_user_id = Auth::id();
        $expense->amount = '-' . $old_expense->amount;
        $expense->expense_date = $old_expense->expense_date;
        $expense->vendor_id = $request->vendor_id;
        $expense->paid_by = 0;
        $expense->reimbursment = 0;
        $expense->receipt = $old_expense->receipt;
        $expense->note = 'This expense is the vendor reimbursment from Expense #' . $old_expense->id;

        $expense->save();
        }       
    }  

    $count = count($request->amount);
    for($i = 0; $i < $count; ++$i){
        if($request->amount[$i] == null){

        } else {
        $expense = new Expense;
        $expense->project_id = $request->project_id[$i];
        if($request->check_id == null){
            $expense->check_id = null;
        } else {
            $expense->check_id = $check->id;
        }
        $expense->created_by_user_id = Auth::id();
        $expense->amount = $request->amount[$i];
        $expense->expense_date = $request->expense_date;
        $expense->vendor_id = $request->vendor_id;
        $expense->paid_by = $request->paid_by;
        $expense->invoice = $request->invoice;
        $expense->reimbursment = 0;

        $expense->save();
        }       
    }  

    $count = count($request->bid);
    for($i = 0; $i < $count; ++$i){
        if($request->bid[$i] == null OR $request->bid[$i] == 0){

        } else {
            if(Bid::where('vendor_id', $request->vendor_id)->where('project_id', $request->project_id[$i])->count() > 0) {
                $bid = Bid::findOrFail(Bid::where('vendor_id', $request->vendor_id)->where('project_id', $request->project_id[$i])->first()->id);
                $bid->amount = $request->bid[$i];
                $bid->update();
            } else {
            $bid = new Bid;
            $bid->project_id = $request->project_id[$i];
            $bid->amount = $request->bid[$i];
            $bid->vendor_id = $request->vendor_id;
            $bid->created_by_user_id = Auth::id();
            $bid->save();
            }       
        }
    }
    return redirect(Session::pull('takemeback'))->with('success', 'Vendor payment was added.');
    }

    public function payment()
    {
        dd('in VendorController.payment');
        $expenses = Expense::where('vendor_id', $vendor->id)->get();

        return view('vendors.payment', compact('vendor', 'expenses'));
    }

    public function index()
    {
        $subs = Vendor::where('biz_type', 1)->orderBy('business_name')->get();
        $retail = Vendor::where('biz_type', 2)->orderBy('business_name')->get();
        
        return view('vendors.index', compact('retail', 'subs'));
    }

    public function create(User $user)
    {
        if(URL::previous() == URL::current()) {
        } else {
            Session::put('takemeback', URL::previous());
        }

        $users = User::all();
        return view('vendors.create', compact('users'));
    }

    public function store(StoreVendor $request)
    {
        $vendor = new Vendor;

        $vendor->business_name = $request->business_name;
        $vendor->biz_type = $request->biz_type;
        $vendor->note = $request->note;
        $vendor->address = $request->address;
        $vendor->address_2 = $request->address_2;
        $vendor->city = $request->city;
        $vendor->state = $request->state;
        $vendor->zip_code = $request->zip_code;
        $vendor->biz_phone = $request->biz_phone;
        $vendor->created_by_user_id = Auth::id(); // who created this vendor
        $vendor->save();

//Create App/User with the new vendor
        //Update current App/User('user_id') with the new vendor_id
        if(isset($request->user_id)) 
        {
            $vendor->users()->attach($request->user_id);

            $user = User::findOrFail($request->user_id);
            $user->created_by_user_id = Auth::id();
            $user->primary_vendor = $vendor->id;
            $user->save();
  
        //if User not selected from dropdown create new User ignore User inputs
        } elseif (isset($request->first_name)) {
            $user = User::create([
            'first_name' => $request['first_name'], 
            'last_name' => $request['last_name'], 
            'email' => $request['email'], 
            'phone_number' => $request['phone_number'],
            'primary_vendor' => $vendor->id
            ]);
            $user->password = bcrypt('Designspilka123#');
            
            $vendor->users()->attach($user->id);
            $user->primary_vendor = $vendor->id;
            $user->created_by_user_id = Auth::id();
            $user->save();
        //Create App/User WITHOUT the new vendor_id
        } else {

        }

        //UPDATE ALL Users of Vendor if Vendor is employee of Auth user. 
        //where USer vendor_id = Vendor, change belongs_to on vendor
        return redirect(Session::pull('takemeback'))->with('success', 'Contact was added.');
    }

    public function show(Vendor $vendor)
    { 
        if(Auth::user()->primary_vendor == $vendor->id) {
            $users = $vendor->users()->get();

/*          $expenses = Expense::where('vendor_id', $vendor->id)->pluck('check_id');
            $checks = Check::orderBy('date', 'desc')->get();*/

            $bids = Bid::all();
            $hours = User::employees()->get();

            $projects = Project::isActive();
            $balances = Project::notActive();
            
            return view('vendors.show', compact('vendor', 'users', 'checks', 'bids', 'projects', 'balances', 'hours'));
        } else {
            $users = $vendor->users()->get();
            $expenses = $vendor->expenses()->orderBy('expense_date', 'desc')->get();
            $splits = $vendor->expenseSplits()->with('expense')->get();
            $expenses = $expenses->merge($splits);
            //Get checks where (on Checks table) check = any of the arrayed check_id #is
            $checks = Check::whereIn('id', $expenses->pluck('check_id'))->orderBy('date', 'desc')->get();
            $bids = $vendor->bids()->get();
            /*$balances = $vendor->projects()->distinct()->get();*/
            $balances = Project::all();
            
            return view('vendors.show', compact('vendor', 'users', 'checks', 'bids', 'projects', 'balances', 'expenses'));
        }
        
    }

    public function edit(Vendor $vendor)
    {
        return view('vendors.edit', compact('vendor'));
    }

    public function update(StoreVendor $request, Vendor $vendor)
    {
        $vendor->update($request->all());
        return redirect(route('vendors.show', compact('vendor')));
    }

    public function destroy(Vendor $vendor)
    {
        //
    }
}

/*      $balances = Project::whereHas('bids', function ($query) use ($vendor){
            $query->where('amount' , '!=', 0)->where('vendor_id', $vendor->id);
            
        })->with(['bids' => function ($query) { // use ($vendor)
            $query->get()->where('latestStatus.title_id', '!=', 5);
        }])->get();
*/



        //latest project status

/*collect([1, 2, 3, 4])->first(function ($value, $key) {
    
    return $value > 2;
});*/
/*


    $projects = Projectstatus::latest()->groupBy('project_id')->get();
    dd($projects);




        
        $projects = Project::whereHas('projectstatuses', function ($query) use ($project) {
            $query->where('title_id', 5)->where('project_id', $project->id) //where it's the last 
;
        })->get();

// Will return a collection keyed by user_id
$users = Projectstatus::groupBy('project_id');

// Sum each user’s records
$balances = $users->map(function ($user) {
    return $user->where('title_id', 5);
});



        dd($balances);


$projects = $project()->projectstatuses()->orderBy('created_at', 'desc')->get();
    $product = 15;

    $tickets = Ticket::whereHas('subtickets', function ($query) use ($product) {
        $query->where('product_id', $product);
    })->with(['subtickets' => function ($query) use ($product) {
        $query->where('product_id', $product);
    }])->get();






        $projects = Projectstatus::latest()->groupBy('project_id')->get();

        $projects = Projectstatus::with('project')->latest()->groupBy('project_id')->get();

        $projects = Project::whereHas('projectstatuses', function ($q) use ($projectstatusId) {
            $q->where('title_id', $projectstatusId);
        })->latest('created_at')->take(1)->get();

        
        $projects = $result = App\Message::with('user')->latest()->groupBy('user_id')->get();
      */