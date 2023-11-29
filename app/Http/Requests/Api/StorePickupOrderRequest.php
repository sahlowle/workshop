<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            'address' => ['required'],
            'order_phone_number' => ['required'],
            'postal_code' => ['required'],
            'brand' => ['required'],
            'devices' => ['required','array'], // Relation
            'questions' => ['required','array'], // Relation
            'items' => ['required','array'], // Relation
            'vat' => ['required'],
            'subtotal' => ['required'],
            'total' => ['required'],
            'paid_amount' => ['required'],
            'payment_way' => ['required'],
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
