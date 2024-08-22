<?php

namespace App\Http\Requests;

use App\Enums\ChequeStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class ChequeStoreRequest extends FormRequest
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
            'bank_id'=>['required','exists:banks,id'],
            'account_id'=>['required','exists:accounts,id'],
            'number_first_sheet'=>['required'],
            'number_last_sheet'=>['required'],
            'number_sheet'=>['required'],
            'date_received'=>['required'],
            'status'=>['required',new Enum(ChequeStatusEnum::class)]
        ];
    }
}
