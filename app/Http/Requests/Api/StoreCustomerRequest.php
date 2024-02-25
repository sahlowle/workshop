<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreCustomerRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required_if:company_name,null'],
            'company_name' => ['required_if:name,null'],
            'part_of_building' => ['nullable', 'string','max:80'],
            'email' => ['required','email','unique:customers,email','string','max:120'],
            'phone' => ['required','unique:customers,phone','min:12','max:20'],
            'telephone' => ['nullable','unique:customers,telephone','min:7'],
            'address' => ['required','string','max:190'],
            'zone_area' => ['nullable','string','max:30'],
            'postal_code' => ['required','numeric'],
            'city' => ['nullable','string','max:30'],
            'lat' => ['required','max:100'],
            'lng' => ['required','max:100'],
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
