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
            'name' => ['nullable', 'string','min:3','max:80'],
            'email' => [
                'nullable','email',
                Rule::unique('customers')->ignore($this->route('customer'), 'id'),
                'string','max:120'
            ],
            'phone' => [
                'nullable',
                Rule::unique('customers')->ignore($this->route('customer'), 'id'),
                'string','min:9','max:20'
            ],
            'address' => ['nullable','string','min:3','max:190'],
            'zone_area' => ['nullable','string','min:3','max:30'],
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
