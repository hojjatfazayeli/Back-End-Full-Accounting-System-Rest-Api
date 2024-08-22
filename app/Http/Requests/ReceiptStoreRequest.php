<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReceiptStoreRequest extends FormRequest
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
            'receipt_number' => ['required'],
            'deposit_date' => ['required'],
            'bank_list_id' => ['required' , 'exists:bank_lists,id'],
            //'fiscal_document_id' => ['required' , 'exists:fiscal_documents,id'],
            'fiscal_year' => ['required'],
            'fiscal_month' => ['required'],
        ];
    }
}
