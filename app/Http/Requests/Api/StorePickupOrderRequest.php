<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StorePickupOrderRequest extends FormRequest
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
            'type' => ['required'],
            'information' => ['nullable'],
            'order_mode' => ['nullable',Rule::in([1,2,3,4])],
            // 'brand' => ['required'],
            'devices' => ['nullable','array'], // Relation
            'questions' => ['nullable','array'], // Relation
            'items' => ['nullable','array'], // Relation
            'max_maintenance_price' => ['nullable'],
            'paid_amount' => ['nullable'],
            'payment_way' => ['nullable'],
            'is_amount_received' => ['nullable'],
            'is_customer_confirm' => ['nullable'],
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
