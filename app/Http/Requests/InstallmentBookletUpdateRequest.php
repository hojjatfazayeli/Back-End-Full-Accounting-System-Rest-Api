<?php

namespace App\Http\Requests;

use App\Enums\InstallmentBookletNatureInstallmentEnum;
use App\Enums\InstallmentBookletStatusInstallmentEnum;
use App\Enums\InstallmentBookletTypeInstallmentEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class InstallmentBookletUpdateRequest extends FormRequest
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
            //'facility_id' => ['required' , 'exists:facilities,id'],
            //'borrower_id' => ['required' , 'exists:sub_scribers,id'],
            'nature_installment' => ['required' , new Enum(InstallmentBookletNatureInstallmentEnum::class)],
            'type_installment' => ['required' , new Enum(InstallmentBookletTypeInstallmentEnum::class)],
            'payment_year' => ['required' , 'min:4' , 'max:4'],
            'payment_month' => ['required' , 'min:1' , 'max:2'],
            'amount_installment' => ['required'],
            'fiscal_year' => ['required' , 'min:4' , 'max:4'],
            'fiscal_month' => ['required' , 'min:1','max:2'],
            'status' => ['required' , new Enum(InstallmentBookletStatusInstallmentEnum::class)]
        ];
    }
}
