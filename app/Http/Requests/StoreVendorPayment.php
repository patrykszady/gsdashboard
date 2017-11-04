<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class StoreVendorPayment extends FormRequest
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

    if($request->paid_by == 0){
                        $count = count($request->amount);
                    for($i = 0; $i < $count; ++$i){

                        if($request->amount[$i] != null){
                            return [
                            'date' => 'required|date', 
                            'amount.*' => 'nullable|numeric',
                            'bid.*' => 'nullable|numeric',
                            'check_id' => "required|numeric|unique:checks,check",
                            ];
                        } else {
                            //return back to the For statement with the next amount id
                        }
                    }

                    $count = count($request->expense);
                    for($i = 0; $i < $count; ++$i){

                        if($request->expense[$i] == null){
                            //Skip checkbox if unchecked
                        } else {
                            return [
                            'date' => 'required|date', 
                            'amount.*' => 'nullable|numeric',
                            'bid.*' => 'nullable|numeric',
                            'check_id' => "required|numeric|unique:checks,check",
                            ];
                        }
                    }
                    
                    $count = count($request->expense_by_primary_vendor);
                    for($i = 0; $i < $count; ++$i){

                        if($request->expense_by_primary_vendor[$i] == null){
                            //Skip checkbox if unchecked
                        } else {
                            return [
                            'date' => 'required|date', 
                            'amount.*' => 'nullable|numeric',
                            'bid.*' => 'nullable|numeric',
                            'check_id' => "required|numeric|unique:checks,check",
                            ];
                        }
                    }
    } else {
                        $count = count($request->amount);
                        for($i = 0; $i < $count; ++$i){

                            if($request->amount[$i] != null){
                                return [
                                'date' => 'required|date', 
                                'amount.*' => 'nullable|numeric',
                                'bid.*' => 'nullable|numeric',
                                'check_id' => "nullable|numeric|unique:checks,check",
                                'invoice' => "required"
                                ];
                            } else {
                                //return back to the For statement with the next amount id
                            }
                        }

                        $count = count($request->expense);
                        for($i = 0; $i < $count; ++$i){

                            if($request->expense[$i] == null){
                                //Skip checkbox if unchecked
                            } else {
                                return [
                                'date' => 'required|date', 
                                'amount.*' => 'nullable|numeric',
                                'bid.*' => 'nullable|numeric',
                                'check_id' => "nullable|numeric|unique:checks,check",
                                'invoice' => "required"
                                ];
                            }
                        }
                        
                        $count = count($request->expense_by_primary_vendor);
                        for($i = 0; $i < $count; ++$i){

                            if($request->expense_by_primary_vendor[$i] == null){
                                //Skip checkbox if unchecked
                            } else {
                                return [
                                'date' => 'required|date', 
                                'amount.*' => 'nullable|numeric',
                                'bid.*' => 'nullable|numeric',
                                'check_id' => "nullable|numeric|unique:checks,check",
                                'invoice' => "required"
                                ];
                            }
                        }
    }

        return [
        'date' => 'required|date', 
        'amount.*' => 'nullable|numeric',
        'bid.*' => 'nullable|numeric',
        ]; 
    }

}
