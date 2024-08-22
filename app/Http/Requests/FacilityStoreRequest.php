<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FacilityStoreRequest extends FormRequest
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
            'amount_facility' => ['required'],
            'wage' => ['required'],
            'start_installment_date' => ['required'],
            'quantity_installments' => ['required'],
            'amount_first_installment' => ['required'],
            'amount_other_installment' => ['required'],
            'payment_date' => ['required'],
            'fiscal_year' => ['required'],
            'fiscal_month' => ['required'],
            'borrower_id' => ['required'],
            'cheque_id' => ['required'],
            'cheque_sheet_id' => ['required'],
        ];
    }
}
