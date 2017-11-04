<?php

namespace App\Http\Controllers;

use App\Projectstatus;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProjectstatusController extends Controller
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
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $status = Projectstatus::create($request->all());
        $status->created_by_user_id = Auth::id(); //created by
        $status->save();

        return back()->with('success', 'Project status was changed');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Projectstatus  $projectstatus
     * @return \Illuminate\Http\Response
     */
    public function show(Projectstatus $projectstatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Projectstatus  $projectstatus
     * @return \Illuminate\Http\Response
     */
    public function edit(Projectstatus $projectstatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Projectstatus  $projectstatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Projectstatus $projectstatus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Projectstatus  $projectstatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(Projectstatus $projectstatus)
    {
        //
    }
}
