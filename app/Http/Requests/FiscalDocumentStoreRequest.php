<?php

namespace App\Http\Requests;

use App\Enums\FiscalDocumentNatureEnum;
use App\Enums\FiscalDocumentStatusEnum;
use App\Enums\FiscalDocumentTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class FiscalDocumentStoreRequest extends FormRequest
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
            'fiscal_document.nature_document' => ['required' , new Enum(FiscalDocumentNatureEnum::class)],
            'fiscal_document.type_document' => ['required' , new Enum(FiscalDocumentTypeEnum::class)],
            'fiscal_document.title' => ['required'],
            'fiscal_document.description' => ['required'],
            'fiscal_document.document_date' => ['required'],
            'fiscal_document.payment_date' => ['required'],
            'fiscal_document.fiscal_year' => ['required'],
            'fiscal_document.fiscal_month' => ['required'],
            'fiscal_document.status' => ['required' , new Enum(FiscalDocumentStatusEnum::class)],
            'fiscal_document.cheque_id' => ['exists:cheques,id'],
            'fiscal_document.cheque_sheet_id' => ['exists:cheque_sheets,id'],
/*            'items.*.account_id' => ['required' , 'exists:accounts,id'],
            'items.*.description' => ['required' ],
            'items.*.deptor' => ['required' ],
            'items.*.creditor' => ['required' ],
            'items.*.status' => ['required' , new Enum(FiscalDocumentStatusEnum::class)],
            'items.*.fiscal_year' => ['required' ],
            'items.*.fiscal_month' => ['required' ]*/

        ];
    }
}
