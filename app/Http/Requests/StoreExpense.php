<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
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
        //check if antother expense exists with same vendor on same date with same check
        if(isset($request->check_id)){
          $check = Check::where('check', $this->check_id)->first()->id;
        } else {
          $check = 0;
        }
        //expense with $this->check in in 'check'
        $expense = Expense::where('check_id', $check)->where('vendor_id', $this->vendor_id)->where('expense_date', Carbon::parse($this->expense_date)->toDateTimeString())->first();

        //save receipt before validation runs
        if (Request::hasFile('receipt')) {
          //check if file is an image first
          Request::validate([
            'receipt' => 'mimes:jpeg,png',
          ]);

            $receipt = Request::file('receipt'); 
            $filename = date('Y-m-d-H-i-s') .'-' . Auth::id() . '.' . $receipt->getClientOriginalExtension();
            $location = storage_path('files/receipts/' . $filename);
            Image::make($receipt)->save($location);

            Session::put('receipt_img', $filename);
        }       
        return [
          'expense_date' => 'required|date',
          'amount' => 'required|numeric',
          'project_id' => 'required',
          'vendor_id' => 'required|numeric',
          'paid_by' => 'required',
          'invoice' => 'nullable',
          //if $request->expense isset and $expense->check isset, dont allow check to be changed.
          'check_id' => Rule::unique('checks', 'check')->ignore(isset($expense) ? $expense->check->check : '', 'check'),
          'reimbursment' => 'required',
          'note' => 'nullable|min:3',
          'receipt' => 'required_if:reimbursment,Client',
          ];
      }

    public function messages()
    {
        return [
            'receipt.required_if' => 'Receipt required if Client is to reimburse.',
            'receipt.mimes' => 'Receipt file must be an image.',
            'vendor_id.required' => 'Vendor is required.',
            'check_id.unique' => 'Check is already entered.',
            'project_id.required' => 'Project is required.',
            'amount.required' => 'Amount is required.',
            'amount.numeric' => 'Amount must be a number.',
            'expense_date.required' => 'Date is required.',
            'expense_date.numeric' => 'Date must be formatted correctly.',
        ];
    }
}

        
