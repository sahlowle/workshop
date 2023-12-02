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
            'name' => ['required', 'string','min:3','max:120'],
            'company_name' => ['nullable', 'string','min:3','max:120'],
            'part_of_building' => ['nullable', 'string','min:3','max:80'],
            'email' => ['required','email','unique:customers,email','string','max:120'],
            'phone' => ['required','unique:customers,phone','string','min:12','max:20'],
            'telephone' => ['nullable','unique:customers,telephone','string','min:12','max:20'],
            'address' => ['required','string','min:3','max:190'],
            'zone_area' => ['nullable','string','min:3','max:30'],
            'postal_code' => ['nullable','string','min:3','max:30'],
            'city' => ['nullable','string','min:3','max:30'],
            'lat' => ['nullable','max:100'],
            'lng' => ['nullable','max:100'],
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
