<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReceiptInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $this->file !=null ? $file = env('APP_URL').'/'.$this->file : $file=Null;

        return
            [
                'creator'=>$this->admin,
                'fiscal_document' => $this->fiscal_document,
                'bank'=>$this->bank,
                'receipt' =>
                [
                    'id'=>$this->id,
                    'uuid'=>$this->uuid,
                    'title'=>$this->title,
                    'receipt_number'=>$this->receipt_number,
                    'deposit_date'=>$this->deposit_date,
                    'description'=>$this->description,
                    'file'=>$file,
                    'fiscal_year'=>$this->fiscal_year,
                    'fiscal_month'=>$this->fiscal_month,
                    "created_at"=>$this->created_at->format('Y-m-d - H:i:s'),
                    "updated_at"=>$this->updated_at->format('Y-m-d - H:i:s')
                ]

            ];
    }
}
