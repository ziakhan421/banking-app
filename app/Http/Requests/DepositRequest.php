<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepositRequest extends FormRequest
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
            'amount' => 'required|numeric|min:0.01|max:999999999',
        ];
    }

}
