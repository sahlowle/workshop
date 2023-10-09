<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateOrderRequest extends FormRequest
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
            'description' => ['nullable', 'string','min:3','max:250'],
            'address' => ['nullable', 'string','min:3','max:250'],
            'lat' => ['nullable','string','min:3','max:100'],
            'lng' => ['nullable','string','min:3','max:100'],
            'customer_id' => ['nullable','exists:customers,id'],
            'amount' => ['nullable','numeric'],
            'is_visit' => ['nullable','boolean'],
            'first_visit_id' => ['required_if:is_visit,true','exists:orders,id'],
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
