<?php

namespace App\Http\Requests;

use App\Enums\SubScriberMembershipFeeEnum;
use App\Enums\SubScriberMonthlySubscriptionEnum;
use App\Enums\SubscriberMotivationalBenefitsEnum;
use App\Enums\SubscriberParticipationRightsEnum;
use App\Enums\SubScriberStatusEmployeeEnum;
use App\Enums\SubScriberStatusEnum;
use App\Enums\SubScriberStatusPortionEnum;
use App\Models\SubScriber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class SubScriberUpdateRequest extends FormRequest
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
        //$subscriber =  SubScriber::where('mobile',$this->mobile)->first();
        return [
            'firstname'=>['required'],
            'lastname'=>['required'],
            //'nationalcode'=>['min:10','max:10' , \Illuminate\Validation\Rule::unique('sub_scribers')->ignore($subscriber->id)],
           // 'birth_certificate_id'=>[\Illuminate\Validation\Rule::unique('sub_scribers')->ignore($subscriber->id)],
            //'personal_id'=>[ \Illuminate\Validation\Rule::unique('sub_scribers')->ignore($subscriber->id)],
            'mobile'=> ['required'],
            'status_employee'=>['required',new Enum(SubScriberStatusEmployeeEnum::class)],
            'monthly_subscription'=>['required' , new Enum(SubScriberMonthlySubscriptionEnum::class)],
            'membershipـfee'=>['required' , new Enum(SubScriberMembershipFeeEnum::class)],
            'participationـrights'=>['required' , new Enum(SubscriberParticipationRightsEnum::class)],
            'status_portion'=>['required', new Enum(SubScriberStatusPortionEnum::class)],
            'motivational' => ['required' , new Enum(SubscriberMotivationalBenefitsEnum::class)],
            'status'=>['required' , new Enum(SubScriberStatusEnum::class)]
        ];
    }
}
