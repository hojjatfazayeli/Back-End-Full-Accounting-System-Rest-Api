<?php

namespace App\Http\Requests;

use App\Models\FiscalYear;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FiscalYearUpdateRequest extends FormRequest
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
        $data = $this->getRequestUri();
        $newdata = explode('/',$data);
        $fiscal_year =  FiscalYear::where('id',$newdata[6])->first();
        return [
            'year' => ['required' , 'min:4' ,'max:4'],
            'start_date' => ['required'],
            'end_date' => ['required']
        ];
    }
}
