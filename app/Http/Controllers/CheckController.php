<?php

namespace App\Http\Controllers;

use App\Check;
use App\User;

use Illuminate\Http\Request;

use App\Http\Requests\StoreCheck;

class CheckController extends Controller
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
        $checks = Check::orderBy('date', 'desc')->get();
        return view('checks.index', compact('checks'));
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Check  $check
     * @return \Illuminate\Http\Response
     */
    public function show(Check $check)
    {
        return view('checks.show', compact('check'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Check  $check
     * @return \Illuminate\Http\Response
     */
    public function edit(Check $check)
    {
        return view('checks.edit', compact('check'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Check  $check
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCheck $request, Check $check)
    {
        $check->date = $request->date;
        $check->check = $request->check;
        $check->save();
        
        return view('checks.show', compact('check'));   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Check  $check
     * @return \Illuminate\Http\Response
     */
    public function destroy(Check $check)
    {
        //destroy any splits associated with this expense
        //delete expenses attached to check
        $check->expenses()->delete();
        //delete hours attached to check
        $check->hours()->delete();
        //finally...delete the check
        $check->delete();   

        return redirect(route('checks.index'))->with('success', 'Check and all associated data was deleted.');
    }
}
