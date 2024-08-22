<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubScriberInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $this->avatar !=null ? $avatar = env('APP_URL').'/'.$this->avatar : $avatar=Null;

        return
            [
                'creator'=>$this->admin,
                'subscriber'=>
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
                    'monthly_subscription'=>$this->monthly_subscription,
                    'membershipـfee'=>$this->membershipـfee,
                    'participationـrights'=>$this->participationـrights,
                    'status_portion'=>$this->status_portion,
                    'motivational'=>$this->motivational,
                    'status'=>$this->status,
                    "created_at"=>$this->created_at->format('Y-m-d - H:i:s'),
                    "updated_at"=>$this->updated_at->format('Y-m-d - H:i:s')
                ]

            ];
    }
}
