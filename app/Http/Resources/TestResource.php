<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $sentence = "اینجا کلمه1 و کلمه2 در میان یک جمله است.";
        return
            [
                'fiscal_document_item' =>
                    [
                        'account' => mt_rand('11111' , '99999'),
                        'id'=>$this->id,
                        'type'=>'debtor',
                        'payment_tracking_code' => $this->payment_tracking_code,
                        'description' => $this->description,
                        'payment_type'=>$this->payment_type,
                        'fiscal_year'=>$this->fiscal_year,
                        'fiscal_month'=> $this->fiscal_month,
                        'amount' => $this->payment_amount,
                    ],

                'fiscal_document' =>
                    [
                        'serial_code' => mt_rand('111111' , '999999')
                    ]
            ];
    }
}
