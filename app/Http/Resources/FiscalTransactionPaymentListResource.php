<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FiscalTransactionPaymentListResource extends JsonResource
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
                'id'=>$this->id,
                'uuid'=>$this->uuid,
                'type'=>$this->type,
                'payment_type'=>$this->payment_type,
                'fiscal_year'=>$this->fiscal_year,
                'fiscal_month'=>$this->fiscal_month,
                'payment_date'=>$this->payment_date,
                'payment_amount'=>$this->payment_amount,
                'payment_tracking_code'=>$this->payment_tracking_code,
                'card_number'=>$this->card_number,
                'file'=>env('APP_STORAGE').'/'.$this->file,
                'description'=>$this->description,
                'bank'=>$this->bank,
                'checker'=>$this->admin,
                'status'=>$this->status,
                "created_at"=>$this->created_at->format('Y-m-d - H:i:s'),
                "updated_at"=>$this->updated_at->format('Y-m-d - H:i:s')
            ];
    }

}
