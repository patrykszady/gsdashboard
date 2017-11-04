<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;


class StoreUser extends FormRequest
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

        if((isset($request->client_id) or isset($request->vendor_id)) and isset($request->user_id)) {
            return [
            ];
       
        }else {
            return [
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'phone_number' => 'nullable|numeric|digits:10',
            'email' => 'required|email|max:255|unique:users,email,' . $this->user,
            ];
        }
        
    }
}