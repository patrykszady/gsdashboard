<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class StoreProject extends FormRequest
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
        if($request->jobsite_address == 1) {
            return [
            'project_name' => 'required|min:3',
            'client_id' => 'required|numeric',
            'note' => 'nullable|min:3',
            'project_total' => 'nullable|numeric',
            ];
        } else {
            return [
            'project_name' => 'required|min:3',
            'client_id' => 'required|numeric',
            'note' => 'nullable|min:3',
            'address' => 'required|min:3',
            'address_2' => 'nullable|min:1',
            'city' => 'required|min:3',
            'state' => 'required|min:2',
            'zip_code' => 'required|numeric',
            'project_total' => 'nullable|numeric',
            ];
        }
    }
}
