<?php

namespace App\Http\Controllers;

use App\ExpenseSplit;
use App\Projectstatus;
use App\Project;
use App\Expense;
use App\Client;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProject;

use Illuminate\Support\Facades\Auth;

use Session;
use URL;
use DB;

class ProjectController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $projects = Project::all();
        return view('projects.index', compact('projects'));
    }

    public function create(Client $client)
    {
        //if creating new client, take back here afterwards
        if(URL::previous() == URL::current()) {
        } else {
            Session::put('takemeback', URL::current());
        }
        
        if(isset($client->id)) {
            $clients = Client::all();
            return view('projects.create', compact('client', 'clients'));
        } else {
            $clients = Client::all();
            return view('projects.create', compact('clients'));
        }         
    }

    public function store(StoreProject $request)
    {
        $project = new Project;
        $project->project_name = $request->project_name;
        $project->client_id = $request->client_id;
        $project->note = $request->note;
        $project->created_by_user_id = Auth::id();
        $project->project_total = $request->project_total;

        if($request->jobsite_address == 1) {
            $client = Client::findOrFail($request->client_id);
            $project->address = $client->address;
            $project->address_2 = $client->address_2;
            $project->city = $client->city;
            $project->zip_code = $client->zip_code;
            $project->state = $client->state;

        } elseif($request->jobsite_address == 2){
            $project->address = $request->address;
            $project->address_2 = $request->address_2;
            $project->city = $request->city;
            $project->zip_code = $request->zip_code;
            $project->state = $request->state;
        }

        $project->save();

        $projectstats = new Projectstatus;
        $projectstats->project_id = $project->id;
        $projectstats->title_id = 1;
        $projectstats->created_by_user_id = Auth::id();
        $projectstats->save();

        return redirect(route('projects.show', $project->id))->with('success', 'Project ' . $project->project_name . ' was created.');
    }

    public function show(Project $project)
    {
        $timesheets = $project->hours()->groupBy('user_id')->latest()->get();
        //combine expenses and expensesplits into one collection. if expense has splits, remove that item but add in all the details to each expensesplit.
        $expenses = $project->expenses()->get();
        $splits = $project->expenseSplits()->with('expense')->get();
        $expenses = $expenses->merge($splits);

        /* $vendor_expenses = $project->expenses()->select('*', DB::raw('sum(amount) as total'))->groupBy('vendor_id')->orderBy('total', 'DESC')->get();*/
        $vendor_expenses = $project->vendors()->get();

        $reimbursment = $expenses->where('reimbursment', 'Client');

        $users = $project->client->users()->get();

        return view('projects.show', compact('project', 'expenses', 'expense_splits', 'vendor_expenses', 'timesheets', 'users', 'title_id', 'reimbursment'));
    }

    public function edit(Project $project)
    {
        if(URL::previous() == URL::current()) {

        } else {
            Session::put('takemeback', URL::previous());
        }

        $clients = Client::all();

        return view('projects.edit', compact('project', 'clients'));
    }

    public function update(StoreProject $request, Project $project)
    {
        $project->update($request->all());
        $project->created_by_user_id = Auth::id();

        $project->save();
    

        return redirect(Session::pull('takemeback'))->with('success', 'Project ' . $project->project_name . ' was edited.');
    }

    public function destroy(Project $project)
    {
        //
    }
}



/*
$this->validate($request, array(
        'title' => 'required|max:255',
    ));*/