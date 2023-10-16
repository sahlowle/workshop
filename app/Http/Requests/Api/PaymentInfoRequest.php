<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PaymentInfoRequest extends FormRequest
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
            'payment_intent' => ['required','string','max:1024'],
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
