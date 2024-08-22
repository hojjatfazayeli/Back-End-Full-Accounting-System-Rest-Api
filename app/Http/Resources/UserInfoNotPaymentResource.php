<?php

namespace App\Http\Resources;

use App\Models\FiscalYearsItem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserInfoNotPaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       $fiscal_year_item =  FiscalYearsItem::where('status' , 'active')->first();
        return
            [
                'id'=> $this->id,
                'uuid' => $this->uuid,
                'firstname' => $this->firstname,
                'lastname' => $this->lastname,
                'membershipـfee' => $this->membershipـfee,
                'amount_membership_fee' => $fiscal_year_item->amount_membership_fee
            ];
    }
}
