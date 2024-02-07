<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        /**
         * Validation rules
         *
         * @var array
         */
        return [
            'email' => 'required|exists:users,email',
            'amount' => 'required|numeric|min:0.01|max:999999999',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'email.exists' => 'The requested email address does not found.',
        ];
    }
}
