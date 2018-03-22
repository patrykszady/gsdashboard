<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

use App\Expense;

use Session;

class StoreExpenseSplit extends FormRequest
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
    public function rules(Request $request)
    {
        //Check if all input['amount[]'] = the same amount as expense->amount
        $expense = Expense::findOrFail($request->expense_id);
        
        $amount_split = $expense->amount - round(array_sum($request->amount), 2) == 0;
        if($amount_split == false) {
            return [
                'amount_total' => 'required', //amount_total actually doesnt exists but fails if the IF statement is true ($amount_split ==false).
                'amount.*' => 'required|numeric|min:0.01',
                'project_id.*' => 'required',
            ];
        } else {

        return [
            'amount.*' => 'required|numeric|min:0.01',
            'project_id.*' => 'required',
        ];     
        }
    }

    public function messages()
    {
        //can we say Project_name hours... and know if letters or floats are typed, makes for more personalized error messages
        return [
            'amount.*' => 'Amount :attribute must be a number and not empty',
            'project_id.*' => 'Project :attribute must be selected',
            'amount_total.required' => 'All Amounts have to add up to the Expense amount',
        ];
    }
}
