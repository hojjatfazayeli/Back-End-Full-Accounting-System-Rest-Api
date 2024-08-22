<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FiscalTransactionStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fiscal_year' => ['required'],
            'fiscal_month' => ['required'],
            'payment_date' => ['required'],
            'payment_amount' => ['required'],
            'payment_tracking_code' => ['required'],
            'card_number' => ['required'],
            'file' => ['required' , 'file']
        ];
    }
}
