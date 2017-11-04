<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;


class StoreDistributionProject extends FormRequest
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
        return [
        'account.*' => 'required|integer|min:10|max:100'
        ];
    }

    public function messages()
    {
        //can we say Project_name hours... and know if letters or floats are typed, makes for more personalized error messages
        return [
            'account.*' => 'Percent must be numeric and integer. At least 10% and 100% max',
        ];
    }
        
}