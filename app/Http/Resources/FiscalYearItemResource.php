<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FiscalYearItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return
            [
                'id'=>$this->resource->id,
                'uuid'=>$this->uuid,
                'amount_membershipـright_month'=>$this->amount_membershipـright_month,
                'amount_participate_right'=>$this->amount_participate_right,
                'amount_membership_fee'=>$this->amount_membership_fee,
                'amount_motivational'=>$this->amount_motivational,
                'status'=>$this->status,
                "created_at"=>$this->created_at->format('Y-m-d - H:i:s'),
                "updated_at"=>$this->updated_at->format('Y-m-d - H:i:s')
            ];
    }
}
