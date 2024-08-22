<?php

namespace App\Http\Requests;

use App\Enums\AccountGroupeNatureEnum;
use App\Enums\AccountGroupeStatusEnum;
use App\Enums\AccountGroupeTypeEnum;
use App\Enums\AccountNeedChequeEnum;
use App\Enums\AccountNeedReceiptEnum;
use App\Enums\AccountStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class AccountStoreRequest extends FormRequest
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
            'account_groupe_id'=> ['required' , 'exists:account_groupes,id'],
            'title'=> ['required'],
            'totalcode' => ['required','min:2','max:3' , 'exists:account_groupes,total_code'],
            'specificcode' => ['required','min:2','max:2'],
            'detailedcode' => ['required','min:6','max:6'],
            //'need_entity' => ['required' , new Enum(AccountNeedChequeEnum::class)],
           // 'status_account' => ['required' , new Enum(AccountStatusEnum::class)]
        ];
    }
}
