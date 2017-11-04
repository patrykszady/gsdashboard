<?php

namespace App\Http\Controllers;

use App\Bid;
use App\Vendor;
use App\Project;
use Illuminate\Http\Request;

use URL;
use Auth;
use Session;

class BidController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    


    public function index()
    {
        $bids = Bid::all();
        return view('bids.index', compact('bids'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Vendor $vendor)
    {
        if(URL::previous() == URL::current()) {

        } else {
            Session::put('takemeback', URL::previous()); 
        }

        $vendors = Vendor::all();
     /*   if(isset($vendor->id)){
            $projects = 
        }*/
        if(isset($vendor->id)) {
            $bids = Bid::where('vendor_id', '=', $vendor->id)->pluck('project_id');
            $projects = Project::whereNotIn('id', $bids)->get();    
        } else {
            $projects = Project::all();
        }
       
        return view('bids.create', compact('vendor','vendors', 'projects'));
    }

    public function store(Request $request)
    {
        $count = count($request->amount);
        for($i = 0; $i < $count; ++$i){
            if($request->amount[$i] == null){

            } else {

            $bid = new Bid;
            $bid->amount = $request->amount[$i];
            $bid->project_id = $request->project_id[$i];
            $bid->vendor_id = $request->vendor_id;
            $bid->created_by_user_id = Auth::id();

            $bid->save();

            }
        }

        return redirect(Session::pull('takemeback'))->with('success', 'Bids for ' . $bid->vendor->business_name . ' were added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bid  $bid
     * @return \Illuminate\Http\Response
     */
    public function show(Bid $bid)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bid  $bid
     * @return \Illuminate\Http\Response
     */
    public function edit(Bid $bid)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bid  $bid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bid $bid)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bid  $bid
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bid $bid)
    {
        //
    }
}
