<?php

namespace App\Http\Requests;

use App\Enums\FamilySubScriberLifeSituationEnum;
use App\Enums\FamilySubScriberRelationEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class FamilySubScriberUpdateRequest extends FormRequest
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
            'firstname'=>['required' , 'min:3'],
            'lastname'=>['required' , 'min:3'],
            'nationalcode'=>['min:10','max:10'],
            'mobile' => ['min:11' , 'max:11'],
            'relation' => ['required' , new Enum(FamilySubScriberRelationEnum::class)],
            'life_situation' => ['required' , new Enum(FamilySubScriberLifeSituationEnum::class)]
        ];
    }
}
