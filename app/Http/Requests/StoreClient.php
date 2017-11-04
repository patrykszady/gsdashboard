<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

use Session;

class StoreClient extends FormRequest
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
        //if User not selected from dropdown create new User/ else ignore User inputs
        /*if($request->user_id == null or Session::get('user_id') == null)*/

        if($request->user_id == null) {
            return [
            'business_name' => 'nullable|min:3',
            'address' => 'required|min:3',
            'address_2' => 'nullable|min:1',
            'city' => 'required|min:3',
            'state' => 'required|min:2',
            'zip_code' => 'required|numeric|digits:5',
            'note' => 'nullable',
            'home_phone' => 'nullable|numeric|digits:10',
            'first_name' => 'sometimes|required|min:2',
            'last_name' => 'sometimes|required|min:2',
            'phone_number' => 'sometimes|nullable|numeric|digits:10',
            'email' => 'sometimes|required|email|max:255|unique:users',
            'source' => 'nullable|min:3|max:120',
            // 'email.*' => 'required|email|max:255',
            ];
        } else {
            return [
            'business_name' => 'nullable|min:3',
            'address' => 'required|min:3',
            'address_2' => 'nullable|min:1',
            'city' => 'required|min:3',
            'state' => 'required|min:2',
            'zip_code' => 'required|numeric|digits:5',
            'note' => 'nullable',
            'home_phone' => 'nullable|numeric|digits:10',
            'source' => 'nullable|min:3|max:120',
            ];
        }
        
    }
}
