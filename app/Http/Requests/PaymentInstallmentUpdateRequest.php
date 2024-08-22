<?php

namespace App\Http\Requests;

use App\Enums\PaymentInstallmentStatusEnum;
use App\Enums\PaymentInstallmentTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class PaymentInstallmentUpdateRequest extends FormRequest
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
            'installment_booklet_id' => ['required' , 'exists:installment_booklets,id'],
            'payer_id' => ['required' , 'exists:sub_scribers,id'],
            'bank_list_id' => ['required' , 'exists:bank_lists,id'],
            'payment_type' => ['required' , new Enum(PaymentInstallmentTypeEnum::class)],
            'payment_date' => ['required'],
            'payment_amount' => ['required'],
            'payment_tracking_code' => ['required'],
            'card_number' => ['required'],
            'fiscal_year' => ['required'],
            'fiscal_month' => ['required'],
            'status' => ['required' , new Enum(PaymentInstallmentStatusEnum::class)]
        ];
    }
}
