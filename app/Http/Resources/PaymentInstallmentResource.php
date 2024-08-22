<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentInstallmentResource extends JsonResource
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
                'facility' => $this->facility,
                'installment_booklet' => $this->installment_booklet,
                'payer' => $this->subscriber,
                'bank' => $this->bank,
                'checker' => $this->admin,
                'payment_installment' =>
                [
                    'id'=> $this->id,
                    'uuid' => $this->uuid,
                    'payment_type' => $this->payment_type,
                    'payment_date' => $this->payment_date,
                    'payment_amount' => $this->payment_amount,
                    'payment_tracking_code' => $this->payment_tracking_code,
                    'card_number' => $this->card_number,
                    'file' => env('APP_STORAGE').'/'.$this->file,
                    'description' => $this->description,
                    'fiscal_year' => $this->fiscal_year,
                    'fiscal_month' => $this->fiscal_month,
                    'status' => $this->status,
                    "created_at"=>$this->created_at->format('Y-m-d - H:i:s'),
                    "updated_at"=>$this->updated_at->format('Y-m-d - H:i:s'),

                ]
            ];
    }
}
