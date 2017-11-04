<?php

namespace App\Http\Controllers;

use App\ClientPayment;
use App\Project;
use Illuminate\Http\Request;

use Auth;
class ClientPaymentController extends Controller
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
        if(URL::previous() == URL::current()) {

        } else {
            Session::put('takemeback', URL::previous()); 
        }

        $projects = Project::isActive();

        return view('clientpayments.create', compact('projects'));
        dd($projects);
    }

    public function store(ClientPayment $request)
    {
        $payment = new ClientPayment;
        $payment->project_id = $request->project_id;
        $payment->amount = $request->amount;
        $payment->date = $request->date;
        $payment->check_id = $request->check_id;
        $payment->created_by_user_id = Auth::id();
        $payment->note = $request->note;

        $payment->save();

        return redirect(Session::pull('takemeback'))->with('success', 'Payment for project was added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ClientPayment  $clientPayment
     * @return \Illuminate\Http\Response
     */
    public function show(ClientPayment $clientPayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ClientPayment  $clientPayment
     * @return \Illuminate\Http\Response
     */
    public function edit(ClientPayment $clientPayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ClientPayment  $clientPayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClientPayment $clientPayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ClientPayment  $clientPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClientPayment $clientPayment)
    {
        //
    }
}
