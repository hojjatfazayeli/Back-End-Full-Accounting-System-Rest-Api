<?php

namespace App\Http\Requests;

use App\Enums\FiscalYearsItemStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class FiscalYearItemStoreRequest extends FormRequest
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
            'amount_membershipـright_month' => ['required'],
            'amount_participate_right' => ['required'],
            'amount_membership_fee' => ['required'],
            'amount_motivational' => ['required'],
            'status' => ['required' , new Enum(FiscalYearsItemStatusEnum::class)]
        ];
    }
}
