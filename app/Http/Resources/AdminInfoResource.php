<?php

namespace App\Http\Resources;

use App\Models\FiscalYear;
use App\Models\FiscalYearsItem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $this->avatar !=null ? $avatar = env('APP_URL').'/'.$this->avatar : $avatar=Null;
        $active_fiscal_year = FiscalYear::where('status','active')->first();
        $active_fiscal_year_item = FiscalYearsItem::where('status','active')->first();
        return
            [
                'id'=>$this->id,
                'uuid'=>$this->uuid,
                'firstname'=>$this->firstname,
                'lastname'=>$this->lastname,
                'nationalcode'=>$this->nationalcode,
                'birth_certificate_id'=> $this->birth_certificate_id,
                'status_marital'=> $this->status_marital,
                'personal_id'=>$this->personal_id,
                'fathername'=>$this->fathername,
                'place_birth'=>$this->place_birth,
                'place_issuance_birth_certificate'=>$this->place_issuance_birth_certificate,
                'birth_date'=>$this->birth_date,
                'date_employeement'=>$this->date_employeement,
                'state_id'=>$this->state_id,
                'city_id'=>$this->city_id,
                'office_address'=>$this->office_address,
                'home_address'=>$this->home_address,
                'postalcode'=>$this->postalcode,
                'phone'=>$this->phone,
                'mobile'=>$this->mobile,
                'avatar'=>$avatar,
                'status_employee'=>$this->status_employee,
                'status'=>$this->status,
                "created_at"=>$this->created_at->format('Y-m-d - H:i:s'),
                "updated_at"=>$this->updated_at->format('Y-m-d - H:i:s'),
                'role'=>RoleInfoResource::collection($this->roles),
                'permissions'=>PermissionInfoResource::collection($this->permissions),
                'active_fiscal_year' =>
                [
                    'id' => $active_fiscal_year->id,
                    'year' => $active_fiscal_year->year,
                    'start_date' => $active_fiscal_year->start_date,
                    'end_date' => $active_fiscal_year->end_date,
                ],
                'active_fiscal_year_item' =>
                [
                    'id' => $active_fiscal_year_item->id,
                    'amount_membershipـright_month' => $active_fiscal_year_item->amount_membershipـright_month,
                    'amount_participate_right' => $active_fiscal_year_item->amount_participate_right,
                    'amount_membership_fee' => $active_fiscal_year_item->amount_membership_fee,
                    'amount_motivational' => $active_fiscal_year_item->amount_motivational,
                    'fee_percentage' => $active_fiscal_year_item->fee_percentage,
                ]
            ];
    }
}
