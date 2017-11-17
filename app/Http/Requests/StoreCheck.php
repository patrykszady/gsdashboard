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

class StoreCheck extends FormRequest
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
      return [
        'date' => 'required|date',
        'check' => "required|unique:checks,check," . Request::get('check_id') . "'",
        ];
    }

    public function messages()
    {
        return [
          'check.unique' => 'Check is already entered.',
          'date.required' => 'Date is required.',
          'date.numeric' => 'Date must be formatted correctly.',
        ];
    }
}

        
