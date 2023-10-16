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
            'maintenance_device' => ['nullable', 'string','max:250'],
            'brand' => ['nullable', 'string','max:250'],
            'additional_info' => ['nullable', 'string','max:250'],
            'block_no' => ['nullable', 'string','max:250'],
            'order_phone_number' => ['nullable', 'string','min:9','max:250'],
            'floor_number' => ['nullable', 'string','min:1','max:250'],
            'apartment_number' => ['nullable', 'string','max:250'],
            'lat' => ['nullable','string','min:3','max:100'],
            'lng' => ['nullable','string','min:3','max:100'],
            'customer_id' => ['nullable','exists:customers,id'],
            'amount' => ['nullable','numeric'],
            'is_visit' => ['nullable','boolean'],
            'is_paid' => ['nullable','boolean'],
            'first_visit_id' => ['required_if:is_visit,true','exists:orders,id'],
            'report' => ['nullable'],
            'status' => ['nullable','in:1,2,3,4'],
            'payment_way' => ['nullable','in:1,2'],
            'payment_id' => ['nullable','string','max:1024'],
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