<?php

namespace App\Http\Requests;

use App\Enums\AccountGroupeNatureEnum;
use App\Enums\AccountGroupeStatusEnum;
use App\Enums\AccountGroupeTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class AccountGroupeStoreRequest extends FormRequest
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
        return
            [
                'fiscal_year'=> ['required'],
                'title'=> ['required'],
                'total_code' => ['required','min:2','max:3'],
                'type_account' => ['required' , new Enum(AccountGroupeTypeEnum::class)],
                'nature_account' => ['required' , new Enum(AccountGroupeNatureEnum::class)],
                'status_account' => ['required' , new Enum(AccountGroupeStatusEnum::class)]
        ];
    }
}
