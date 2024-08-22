<?php

namespace App\Http\Requests;

use App\Enums\FiscalYearStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class FiscalYearStoreRequest extends FormRequest
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
            'year' => ['required' , 'min:4' ,'max:4'],
            'start_date' => ['required'],
            'end_date' => ['required'],
            'status' => ['required' , new Enum(FiscalYearStatusEnum::class)]
        ];
    }
}
