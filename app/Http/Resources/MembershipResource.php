<?php

namespace App\Http\Resources;

use App\Models\AccountSubScriber;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MembershipResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $account_subscriber = $this->subscriber->account_subscriber->where('type' , 'membership')->first();
        return
            [
                'account' => $account_subscriber->account,
                'id'=>$this->id,
                'type'=>$this->type,
                'payment_tracking_code' => $this->payment_tracking_code,
                'description' => $this->description,
                'payment_type'=>$this->payment_type,
                'fiscal_year'=>$this->fiscal_year,
                'fiscal_month'=> $this->fiscal_month,
                'payment_amount' => $this->payment_amount
            ];
    }
}
