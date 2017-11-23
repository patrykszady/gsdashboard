<?php

namespace App\Http\Controllers;

use App\Receipt;
use App\Expense;
use App\Vendor;
use App\Project;
use App\Distribution;

use PDF;
use Image;
use Storage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Ddeboer\Imap\Server;
use Ddeboer\Imap\SearchExpression;
use Ddeboer\Imap\Search\Flag\Unseen;
use Ddeboer\Imap\Search\Email\FromAddress;
use Ddeboer\Imap\Message\Attachment;


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

        $receipts = Receipt::all();
        $server = new Server('outlook.office365.com');

        // $connection is instance of \Ddeboer\Imap\Connection
        $connection = $server->authenticate('patryk@gs.construction', 'Pilka123#');

        foreach($receipts as $receipt){
        $mailbox = $connection->getMailbox($receipt->mailbox);

        //get emails only FROM the address (homedepotreceipt@homedepot.com)
        $search = new SearchExpression();
        $search->addCondition(new FromAddress($receipt->from_address));
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
                } else {
                    foreach($message->getParts() as $part) {
                   
                        if($part->getSubtype() == 'HTML'){
                            $string = $message->keepUnseen()->getBodyHtml();
                            $message_type = 'HTML';
                        } elseif($part->getSubtype() == 'PLAIN') {
                            $string = $message->keepUnseen()->getBodyText(); 
                            $message_type = 'PLAIN';
                        } else {
                            
                        }
                    }
                }
              /*       print_r( htmlspecialchars($string));  <--SHOW HTML ALL TEXT
                dd();*/
                    $receipt_start = strpos($string, $receipt_start);

                    $receipt_end = strpos($string, $receipt_end, $receipt_start);

                    $receipt_position = $receipt_end - $receipt_start;
                    $receipt_html_main = substr($string, $receipt_start, $receipt_position);
                 /*     print_r( htmlspecialchars($receipt_html_main));  
                dd();*/
            $amount_start = $receipt->amount_start;  /*...returns =    "TOTAL          -$"*/
            $amount_end = $receipt->amount_end;
            
            $receipt_html = str_replace(' ','',$receipt_html_main);
            /*echo $receipt_html;*/ // <- This will show us amount start and end
            
            $amount_start_position = strpos($receipt_html, $amount_start); 
           /* dd($amount_start_position);*/
                if($amount_start_position == false) {
                   continue;
                } else {
                    $amount_start_position = $amount_start_position + strlen($amount_start);
                    $amount_end_position = strpos($receipt_html, $amount_end, $amount_start_position);

                    $amount_length = $amount_end_position - $amount_start_position;
                    $amount_string = preg_replace('/[^0-9.]*/', '', substr($receipt_html, $amount_start_position, $amount_length));
                    /*dd($amount_string);*/
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
                    $expense = new Expense;
                    //if receipt is a return
                    if($receipt->receipt_type == 2) { 
                        $expense->amount = '-' . $amount_string;
                    } else {
                        $expense->amount = $amount_string;  
                    }  
                    $expense->receipt_html = $receipt_html_main;
                    $expense->reimbursment = 0;
                    $expense->project_id = $receipt->project_id; //If PO matches a project, use that project
                    $expense->distribution_id = $receipt->distribution_id;
                    $expense->created_by_user_id = $receipt->created_by_user_id; //CHANGE?!? / The user who innitiated the Search
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
                $receipt_filename = $receipt->receipt_filename; //receipt attachment name inlcuding extension..if none, create pdf from email
                    foreach ($attachments as $attachment) {
                        if($attachment->getFilename() == $receipt_filename) {
                            $file = $attachment->getDecodedContent();
                            $name = date('Y-m-d-H-i-s') . '-' . $expense->id . '.pdf';
                            file_put_contents(
                                storage_path('files/receipts/' . $name),
                                $attachment->getDecodedContent()
                            );
                            $expense->receipt = $name;
                        }
                    }
                }
            
                    $mailbox_1 = $connection->getMailbox('RECEIPTS/Saved');
                    $message->move($mailbox_1);
                    $mailbox->expunge();
                    
                    $expense->save();

                }                                           
            } 
        }    
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = Project::all();
        $distributions = Distribution::all();
        $vendors = Vendor::orderBy('business_name', 'asc')->get();
        
        return view('receipts.create', compact('projects', 'vendors', 'distributions')); 
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
