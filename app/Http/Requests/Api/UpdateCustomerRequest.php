<?php

namespace App\Http\Requests\Api;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateCustomerRequest extends FormRequest
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
            'name' => ['nullable', 'string','max:80'],
            'company_name' => ['nullable', 'string','max:120'],
            'part_of_building' => ['nullable', 'string','max:80'],
            'email' => [
                'nullable','email',
                Rule::unique('customers')->ignore($this->route('customer'), 'id'),
                'string','max:120'
            ],
            'phone' => [
                'nullable',
                Rule::unique('customers')->ignore($this->route('customer'), 'id'),
                'string','min:12','max:20'
            ],
            'telephone' => [
                'nullable',
                Rule::unique('customers')->ignore($this->route('customer'), 'id'),
                'string','min:7','max:20'
            ],
            'address' => ['nullable','string','max:190'],
            'zone_area' => ['nullable','string','max:30'],
            'postal_code' => ['nullable','numeric'],
            'city' => ['nullable','string','max:30'],
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
