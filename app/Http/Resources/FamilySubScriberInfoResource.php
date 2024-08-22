<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FamilySubScriberInfoResource extends JsonResource
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
                'subscriber'=>$this->subscriber,
                'family_subscriber'=>
                    [
                        'id'=>$this->id,
                        'uuid'=>$this->uuid,
                        'relation'=>$this->relation,
                        'life_situation'=>$this->life_situation,
                        'firstname'=>$this->firstname,
                        'lastname'=>$this->lastname,
                        'nationalcode'=>$this->nationalcode,
                        'birth_certificate_id'=> $this->birth_certificate_id,
                        'status_marital'=> $this->status_marital,
                        'fathername'=>$this->fathername,
                        'place_birth'=>$this->place_birth,
                        'place_issuance_birth_certificate'=>$this->place_issuance_birth_certificate,
                        'birth_date'=>$this->birth_date,
                        'state_id'=>$this->state_id,
                        'city_id'=>$this->city_id,
                        'home_address'=>$this->home_address,
                        'postalcode'=>$this->postalcode,
                        'mobile'=>$this->mobile,
                        'avatar'=>$avatar,
                        "created_at"=>$this->created_at->format('Y-m-d - H:i:s'),
                        "updated_at"=>$this->updated_at->format('Y-m-d - H:i:s')
                    ]
            ];
    }
}
