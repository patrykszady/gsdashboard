<?php

namespace App\Http\Controllers;

use App\User;
use App\Project;
use App\Expense;
use App\Distribution;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreDistributionProject;

use Validator;
use Session;
use URL;

class DistributionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function projectCreate(Project $project)
    {
        if(URL::previous() == URL::current()) {
        } else {
            Session::put('takemeback', URL::previous());
        }
        //if expense already has splits send to Edit view
        if($project->distributions()->count() > 0){
             return redirect(route('distributions.projectEdit', $project->id));
        }
        //if project is not complete, redirect with message
        if($project->isComplete() == null) {
            return redirect(Session::pull('takemeback'));
     /*       ->with('success', 'Project is not yet complete and cannot be distributed.')*/
        }

        $accounts = Distribution::where('vendor_id', Auth::user()->primary_vendor)->get();
        return view('distributions.projectcreate', compact('project', 'accounts'));
    }

    public function projectStore(StoreDistributionProject $request)
    {
        $count = count($request->account);

        for($i = 0; $i < $count; ++$i){
            $distribution = Distribution::findOrFail($request->distribution_id[$i]);

            $distribution->projects()->attach($request->project_id, [
                'percent' => $request->account[$i],
                'created_by_user_id' => Auth::id(),
                ]);
        }

        return redirect(Session::pull('takemeback'));      
    }
    public function projectEdit(Project $project)
    {
        if(URL::previous() == URL::current()) {

        } else {
            Session::put('takemeback', URL::previous());
        }

        //if project is not ocmplete, redirect with message
        if($project->isComplete() == null) {
            return redirect(Session::pull('takemeback'));
        }
        $accounts = Project::find($project->id)->distributions()->get();

        return view('distributions.projectedit', compact('project', 'accounts'));


        
    }   
    public function projectUpdate(StoreDistributionProject $request, Project $project)
    {
        $count = count($request->account);

        for($i = 0; $i < $count; ++$i){
            $distribution = Distribution::findOrFail($request->distribution_id[$i]);

            $distribution->projects()->updateExistingPivot($request->project_id, [
                'percent' => $request->account[$i],
                'created_by_user_id' => Auth::id(),
                ]);
        }

        return redirect(Session::pull('takemeback'));
    }      

    public function index()
    {
        $distributions = Distribution::where('vendor_id', Auth::user()->primary_vendor)->get();
       /* $projects = Project::with('projectstatuses')->get()->;*/
        $projects = Project::isCompletee();
        return view('distributions.index', compact('distributions', 'projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(URL::previous() == URL::current()) {

        } else {
            Session::put('takemeback', URL::previous());
        }


        $employees = User::employees()->orderBy('first_name', 'asc')->get();
        return view('distributions.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $distribution = Distribution::create([
            'name' => $request['name'], 
            'user_id' => $request['user_id'], 
            'vendor_id' => Auth::user()->primary_vendor
            ]);

        $distribution->created_by_user_id = Auth::id(); //who created this expense

        $distribution->save();

        return redirect(Session::pull('takemeback'));
        //check who user belongs to, becomes vendor_id
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Distribution  $distribution
     * @return \Illuminate\Http\Response
     */
    public function show(Distribution $distribution)
    {
        $expenses = Expense::where('distribution_id', $distribution->id)->get();
        $projects = Project::isCompletee();
        return view('distributions.show', compact('distribution', 'projects', 'expenses'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Distribution  $distribution
     * @return \Illuminate\Http\Response
     */
    public function edit(Distribution $distribution)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Distribution  $distribution
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Distribution $distribution)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Distribution  $distribution
     * @return \Illuminate\Http\Response
     */
    public function destroy(Distribution $distribution)
    {
        //
    }
}
