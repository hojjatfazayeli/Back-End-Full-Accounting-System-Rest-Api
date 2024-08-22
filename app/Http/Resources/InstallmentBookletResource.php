<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InstallmentBookletResource extends JsonResource
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
                'id' => $this->id,
                'uuid' => $this->uuid,
                'facility_code' => $this->facility->code,
                'creator' => $this->admin->firstname .' '. $this->admin->lastname,
                'borrower' => $this->subscribers->firstname.' '.$this->subscribers->lastname,
                'borrower_id' => $this->subscribers->id,
                'nature_installment' => $this->nature_installment,
                'type_installment' => $this->type_installment,
                'payment_date' => $this->payment_date,
                'payment_year' => $this->payment_year,
                'payment_month' => $this->payment_month,
                'amount_installment' =>$this->amount_installment,
                'fiscal_year' => $this->fiscal_year,
                'fiscal_month' => $this->fiscal_month,
                'status'=>$this->status,
                "created_at"=>$this->created_at->format('Y-m-d - H:i:s'),
                "updated_at"=>$this->updated_at->format('Y-m-d - H:i:s'),
            ];
    }
}
