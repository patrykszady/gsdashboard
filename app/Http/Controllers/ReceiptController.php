<?php

namespace App\Http\Controllers;

use App\Receipt;
use App\Expense;
use App\Vendor;
use App\Project;
use App\Distribution;
use App\CompanyEmail;
use App\ReceiptAccount;

use PDF;
use Image;
use Storage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Ddeboer\Imap\Server;
use Ddeboer\Imap\SearchExpression;
use Ddeboer\Imap\Search\Flag\Unseen;
use Ddeboer\Imap\Search\Email\FromAddress;
use Ddeboer\Imap\Search\Text\Subject;
use Ddeboer\Imap\Message\Attachment;
use Ddeboer\Imap\Message\EmailAddress;

class ReceiptController extends Controller
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

    public function makePdfReceipt()
    {
        $pdf = PDF::loadView('receipts.makePdfReceipt')
                ->setPaper('a4'); //->setOrientation('portrait')
        $filename = 'Reimbursment.' . date('Y-m-d-H-i-s') . '.pdf';
        
        $location = storage_path('reimbursments/' . $filename);
    
        return $pdf->stream($location, 'reimbursments.pdf');
        //QUEUE THIS??
    }

    public function index()
    {
        foreach(CompanyEmail::all() as $company_email) {
        $server = new Server($company_email->server);
        // $connection is instance of \Ddeboer\Imap\Connection
        $connection = $server->authenticate($company_email->email, $company_email->password);
        /*$mailbox = $company_email->mailbox;*/
            foreach($company_email->receipt_accounts as $receipt_account) {
            //$mailbox = $connection->getMailbox($receipt->mailbox);
/*                dd(Receipt::where('id', $receipt->receipt_id)->first());*/
            $receipt = $receipt_account->receipt;
            $mailbox = $connection->getMailbox($company_email->mailbox);
            
            $search = new SearchExpression();
                if($receipt->from_type == 1){
                    //get emails only FROM the address (homedepotreceipt@homedepot.com)
                    $search->addCondition(new FromAddress($receipt->from_address));
                } elseif($receipt->from_type == 2){
                    $search->addCondition(new Subject($receipt->from_subject));
                } elseif($receipt->from_type == 3){

                } else {
                  //ignore the $receipt and move on to the next one
                }
            
            $messages = $mailbox->getMessages($search);

                foreach($messages as $message){

                //receipt_html
                $receipt_start = $receipt->receipt_start; //evenrything after last character
                $receipt_end = $receipt->receipt_end; //everything before first character

                //CHECK IF EMAIL IS HTML OR PLAIN TEXT
                if($message->getSubtype() == 'HTML'){
                    $string = $message->keepUnseen()->getBodyHtml();
                    $message_type = 'HTML';
                } elseif($message->getSubtype() == 'PLAIN') {
                    $string = $message->keepUnseen()->getBodyText();
                    $message_type = 'PLAIN';
                } else { //$message->getSubtype() == 'MULTI'
                    foreach($message->getParts() as $part) {
                        if($part->getSubtype() == 'HTML'){
                            $string = $message->keepUnseen()->getBodyHtml();
                            $message_type = 'HTML';
                        } elseif($part->getSubtype() == 'PLAIN') {
                            $string = $message->keepUnseen()->getBodyText(); 
                            $message_type = 'PLAIN';
                        } else { //$part->getSubtype() == 'RELATED'
                            foreach($part->getParts() as $part) { 
                                if($part->getSubtype() == 'HTML'){
                                    $string = $message->keepUnseen()->getBodyHtml();
                                    $message_type = 'HTML';
                                } elseif($part->getSubtype() == 'PLAIN') {
                                    $string = $message->keepUnseen()->getBodyText(); 
                                    $message_type = 'PLAIN';
                                } else { //$part->getSubtype() == 'RELATED'
                                    
                                }
                            }
                        }
                    }
                }
            
            /*    print_r(htmlspecialchars($string));  //<--SHOW HTML ALL TEXT
                dd();*/
                $receipt_start = strpos($string, $receipt_start);

                if($receipt->receipt_end !== "0"){
                    $receipt_end = strpos($string, $receipt_end, $receipt_start);
                } elseif($receipt->receipt_end == "0"){ //if receipt_end = null, use last character of getBodyText()/Html()
                    $receipt_end = strlen($string);
                }

                $receipt_position = $receipt_end - $receipt_start;
                $receipt_html_main = substr($string, $receipt_start, $receipt_position);
            /*    print_r(htmlspecialchars($receipt_html_main));  
                dd();
*/
                $amount_start = $receipt->amount_start;  /*...returns =    "TOTAL          -$"*/
                $amount_end = $receipt->amount_end; 

                
                $receipt_html = str_replace(' ','',$receipt_html_main);
                /*echo $receipt_html; 
                dd();*/
                $amount_start_position = strpos($receipt_html, $amount_start); 
                /*dd($amount_start_position); // <- This will show us amount start and end*/
                /*dd($message);*/



                if($amount_start_position == false) {
                   continue;
                } else { //save the expense!!!
                    $amount_start_position = $amount_start_position + strlen($amount_start);
                    $amount_end_position = strpos($receipt_html, $amount_end, $amount_start_position);

                    $amount_length = $amount_end_position - $amount_start_position;
                    $amount_string = preg_replace('/[^0-9.]*/', '', substr($receipt_html, $amount_start_position, $amount_length));
                  /*  dd($amount_string);*/
                    
                    if($receipt->po == 1){ // 1 = yes 2 = no
                        $po_start = $receipt->po_start;
                        $po_end = $receipt->po_end;
                        //IF PO is supposed to be there but it's not
                        if(strpos($string, $po_start) == false){
                            $po_string = NULL; 
                        } else {
                            $po_start_position = strpos($string, $po_start) + strlen($po_start);
                            $po_end_position = strpos($string, $po_end, $po_start_position);
                            $po_length = $po_end_position - $po_start_position;
                            $po_string = str_replace(" ", "", substr($string, $po_start_position, $po_length));
                        }
                    } else {
                        $po_string = NULL; 
                    }

                    //if receipt is a return
                    if($receipt->receipt_type == 2) { 
                        $amount_string = '-' . $amount_string;
                    } else {
                        $amount_string = $amount_string;  
                    }

                    //Check if expense already exists
                    $duplicate = Expense::
                        where('vendor_id', Vendor::findOrFail($receipt->vendor_id)->id)->
                        where('amount', $amount_string)->
                        where('expense_date', $message->getDate()->format('Y-m-d'))->first();
                    if(isset($duplicate)) {
                    //move email to Saved without creating new expense
                        $mailbox_1 = $connection->getMailbox($company_email->mailbox . '/Saved');
                        $message->move($mailbox_1);
                        $mailbox->expunge();

                        continue;
                    } else {
                        //CREATE NEW Expense
                    
                    $expense = new Expense;
                    $expense->amount = $amount_string;
                    $expense->receipt_html = $receipt_html_main;
                    $expense->reimbursment = 0;
                    $expense->project_id = $receipt_account->project_id; //If PO matches a project, use that project
                    $expense->distribution_id = $receipt_account->distribution_id;
                    $expense->created_by_user_id = 58;//"automated"
                    $expense->expense_date = $message->getDate()->format('m/d/y');
                    $expense->vendor_id = Vendor::findOrFail($receipt->vendor_id)->id; //Vendor_id of vendor being Queued 
                    $expense->note = $po_string;
                    $expense->paid_by = 0;
                    $expense->save();
                        
                    //GET EMAIL ATTACHMENT..if none....make PDF out of HTML
                    $attachments = $message->getAttachments();
                    if(empty($attachments)){
                        //make PDF from HTML
                        $pdf = PDF::loadView('receipts.makePdfReceipt', compact('string', 'message_type'))
                                ->setPaper('a4'); //->setOrientation('portrait')
                        $name = date('Y-m-d-H-i-s') . '-' . $expense->id . '.pdf';
                        
                        $location = storage_path('files/receipts/' . $name);
                        $expense->receipt = $name;
                    
                        $pdf->save($location);

                    } else {      
                    $receipt_filename = $receipt->receipt_filename; //receipt attachment name inlcuding extension.
                        foreach ($attachments as $key => $attachment) {
                            if($attachment->getFilename() == $receipt_filename) {
                                $file = $attachment->getDecodedContent();
                                $name = date('Y-m-d-H-i-s') . '-' . $expense->id . '.pdf';
                                file_put_contents(
                                    storage_path('files/receipts/' . $name),
                                    $attachment->getDecodedContent()
                                );
                                $expense->receipt = $name;
                            } elseif($key == 0) { //IF filename changes each email, get the first one? //works with Houzz
                                $file = $attachment->getDecodedContent();
                                $name = date('Y-m-d-H-i-s') . '-' . $expense->id . '.pdf';
                                file_put_contents(
                                    storage_path('files/receipts/' . $name),
                                    $attachment->getDecodedContent()
                                );
                                $expense->receipt = $name;
                            } else {
                                
                            }
                        }
                    }
                        $mailbox_1 = $connection->getMailbox($company_email->mailbox . '/Saved');
                        $message->move($mailbox_1);
                        $mailbox->expunge();
                        
                        $expense->save();
                    }  //save expense!!! else 
                    } //create expense if not duplicate                                        
                }  //foreach $messages
            }  //foreach $receipts
        }     //foreach $company_email
    }  // index
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $distributions = Distribution::all();
        $vendors = Vendor::orderBy('business_name', 'asc')->get();
        
        return view('receipts.create', compact('vendors', 'distributions')); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $receipt = Receipt::create($request->except(['project_id']));

        if(is_numeric($request->project_id)) {
            $receipt->project_id = $request->project_id;
        } else {
            $receipt->distribution_id = preg_replace("/[^0-9]/","",$request->project_id);
            $receipt->project_id = 0;
        }
        $receipt->created_by_user_id = Auth::id(); //who created this receipt
        $receipt->save();

        return redirect(route('receipts.create'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function show(Receipt $receipt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function edit(Receipt $receipt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Receipt $receipt)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receipt $receipt)
    {
        //
    }
 
}
