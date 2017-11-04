<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class StoreVendor extends FormRequest
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
        if($request->biz_type == 2) {
            return [
            'business_name' => 'required|min:3',
            /*'address' => 'required|min:3',
            'address_2' => 'nullable|min:1',
            'city' => 'required|min:3',
            'state' => 'required|min:2',
            'zip_code' => 'required|numeric',
            'note' => 'nullable',
            'biz_phone' => 'nullable|numeric|digits:10',*/
            // 'email.*' => 'required|email|max:255',
            ];
        } elseif($request->user_id == null) {
            return ['business_name' => 'required|min:3',
            'address' => 'required|min:3',
            'address_2' => 'nullable|min:1',
            'city' => 'required|min:3',
            'state' => 'required|min:2',
            'zip_code' => 'required|numeric',
            'note' => 'nullable',
            'biz_phone' => 'nullable|numeric|digits:10',
            'first_name' => 'sometimes|required|min:2',
            'last_name' => 'sometimes|required|min:2',
            'phone_number' => 'sometimes|nullable|numeric',
            'email' => 'sometimes|required|email|max:255|unique:users',
           
            ];
        } else {
            return [
            'business_name' => 'required|min:3',
            'address' => 'required|min:3',
            'address_2' => 'nullable|min:1',
            'city' => 'required|min:3',
            'state' => 'required|min:2',
            'zip_code' => 'required|numeric',
            'note' => 'nullable',
            'biz_phone' => 'nullable|numeric|digits:10',
            ];
        }
    }
}
