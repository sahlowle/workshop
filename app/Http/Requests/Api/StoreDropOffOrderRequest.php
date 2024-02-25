<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreDropOffOrderRequest extends FormRequest
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
            'reference_no' => ['required', 'exists:orders,reference_no'],
            'with_route' => ['required','boolean'],
            'visit_time' => ['required'],
            'guarantee_id' => ['required'],
            'information' => ['required'],

            'name' => ['nullable'],
            'company_name' => ['nullable'],
            'address' => ['nullable'],
            'postal_code' => ['nullable','numeric'],
            'phone' => ['nullable'],
            'telephone' => ['nullable'],
            'part_of_building' => ['nullable'],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Customize Failed Response 
    |--------------------------------------------------------------------------
    */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => "The given data was invalid.",
            'data' => $validator->errors(),
            'code' => 422,
        ], 
        422));
    }
}
