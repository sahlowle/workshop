<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreOrderRequest extends FormRequest
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
            'description' => ['required', 'string','min:3','max:250'],
            'address' => ['required', 'string','min:3','max:250'],
            'maintenance_device' => ['required', 'string','max:250'],
            'brand' => ['required', 'string','max:250'],
            'additional_info' => ['nullable', 'string','min:3','max:250'],
            'block_no' => ['nullable', 'string','max:250'],
            'order_phone_number' => ['nullable', 'string','min:12','max:20'],
            'floor_number' => ['nullable', 'string','min:1','max:250'],
            'apartment_number' => ['nullable', 'string','max:250'],
            'lat' => ['required','numeric'],
            'lng' => ['required','numeric'],
            'customer_id' => ['required','exists:customers,id'],
            'amount' => ['nullable','numeric'],
            'is_visit' => ['nullable','boolean'],
            'first_visit_id' => ['required_if:is_visit,true','exists:orders,id'],

            'city' => ['nullable','string','max:100'],
            'zone_area' => ['nullable','string','max:100'],
            'postal_code' => ['nullable','string','max:10'],
            'is_pay_later' => ['nullable','boolean'],
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
