<?php

namespace App\Http\Controllers;

use App\User;
use App\Vendor;
use App\Project;
use App\Receipt;
use App\Distribution;
use App\CompanyEmail;
use App\ReceiptAccount;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreReceiptAccount;

class ReceiptAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dd(Receipt::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $receipts_grouped = Receipt::groupBy('vendor_id')->get();
        $receipts = Receipt::all();
/*        $receipt_accounts = ReceiptAccount::employees()->groupBy('account_id')->get();*/
/*        dd($receipt_accounts);*/
        $company_emails = CompanyEmail::where('vendor_id', Auth::user()->primary_vendor)->get(); //where vendor_id = vendor_id of user logged in
        $projects = Project::all(); //Project::this_fucking_vendor? //logged in vendor?
        $distributions = Distribution::all();
    
        
        return view('receiptaccounts.create', compact('receipts', 'company_emails', 'projects', 'distributions', 'receipt_accounts', 'receipts_grouped'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReceiptAccount $request)
    {

        foreach(Receipt::where('vendor_id', $request->vendor_id)->get() as $receipt)
            {
            $receipt_account = ReceiptAccount::create([
                'company_email_id' => $request['company_email_id'],
                ]);
                if($request->project_id == 0 AND is_numeric($request->project_id)) {
                    $receipt_account->project_id = $request->project_id;
/*                    $expense->distribution_id = 0;*/
                } elseif(is_numeric($request->project_id)) {
                    $receipt_account->project_id = $request->project_id;
                } else {
                    $receipt_account->distribution_id = preg_replace("/[^0-9]/","",$request->project_id);
                }
            $receipt_account->receipt_id = $receipt->id;
            $receipt_account->created_by_user_id = Auth::id(); //created by
            $receipt_account->save();
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ReceiptAccount  $receiptAccount
     * @return \Illuminate\Http\Response
     */
    public function show(ReceiptAccount $receiptAccount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ReceiptAccount  $receiptAccount
     * @return \Illuminate\Http\Response
     */
    public function edit(ReceiptAccount $receiptAccount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReceiptAccount  $receiptAccount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReceiptAccount $receiptAccount)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ReceiptAccount  $receiptAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReceiptAccount $receiptAccount)
    {
        //
    }
}
