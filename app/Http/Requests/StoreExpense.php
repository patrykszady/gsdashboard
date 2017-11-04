<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\Expense;
use App\Check;
use App\Hour;

use Illuminate\Http\Request;

use Carbon\Carbon;

use Image;
use Storage;
use Session;

class StoreExpense extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {          

      $expenses = Expense::where('check_id', $this->check_id)->where('check_id', '!=', null)->where('vendor_id', $this->vendor_id)->where('expense_date', Carbon::parse($this->expense_date)->toDateTimeString())->get();

        //save receipt before validation runs
        //NEED TO CHECK IF FILE IS .JPG FIRST!
        if (Request::hasFile('receipt')) {

          //check if file is JPG
            $receipt = Request::file('receipt'); 
            $filename = date('Y-m-d-H-i-s') .'.' . $receipt->getClientOriginalExtension(); //add expense_id somewhere here
            $location = storage_path('files/receipts/' . $filename);
            Image::make($receipt)->save($location);

            Session::put('receipt_img', $filename);
        }       

      if (Session::exists('receipt_img')) {  
        if($expenses->isEmpty()) { 
          return [
            'expense_date' => 'required|date',
            'amount' => 'required|numeric',
            'project_id' => 'required',
            'vendor_id' => 'required|numeric',
            'paid_by' => 'required',
            'invoice' => 'nullable',
            'check_id' => "nullable|unique:checks,check",
            'reimbursment' => 'required',
            'note' => 'nullable|min:3',
/*            'receipt' => 'required_without:receipt_img|required_unless:reimbursment,0',
            'receipt_img' => 'required_unless:reimbursment,0',*/
            ];

        }else {
          return [
            'expense_date' => 'required|date',
            'amount' => 'required|numeric',
            'project_id' => 'required',
            'vendor_id' => 'required|numeric',
            'paid_by' => 'required',
            'invoice' => 'nullable',
            'reimbursment' => 'required',
            //check id => nullable
            'note' => 'nullable|min:3',
/*            'receipt' => 'required_without:receipt_img|required_unless:reimbursment,0',
            'receipt_img' => 'required_unless:reimbursment,0',*/

          ];
        }   
    }
    if($expenses->isEmpty()) { 
          return [
            'expense_date' => 'required|date',
            'amount' => 'required|numeric',
            'project_id' => 'required',
            'vendor_id' => 'required|numeric',
            'paid_by' => 'required',
            'invoice' => 'nullable', /*unique:users,email,' . $this->check_id,*/
            'check_id' => "nullable|unique:checks,check",
            'reimbursment' => 'required',
            'note' => 'nullable|min:3',
/*            'receipt' => 'required_unless:reimbursment,0',*/
            ];

        }else {
          return [
            'expense_date' => 'required|date',
            'amount' => 'required|numeric',
            'project_id' => 'required',
            'vendor_id' => 'required|numeric',
            'paid_by' => 'required',
            'invoice' => 'nullable',
            'reimbursment' => 'required',
            //check id => nullable
            'note' => 'nullable|min:3',
           /* 'receipt' => 'required_unless:reimbursment,0',*/
          ];
        } 
      }
}

        
