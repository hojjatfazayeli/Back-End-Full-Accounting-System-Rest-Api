<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChequeSheetInfoResource extends JsonResource
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
                'creator'=>$this->admin,
                'cheque_sheet'=>
                [
                    'id'=>$this->id,
                    'uuid'=>$this->uuid,
                    'cheque_number'=>$this->cheque_number,
                    'document_number'=>$this->document_number,
                    'series'=>$this->series,
                    'serial'=>$this->serial,
                    'sayyad_id'=>$this->sayyad_id,
                    'date'=>$this->date,
                    'amount'=>$this->amount,
                    'national_code'=>$this->national_code,
                    'description'=>$this->description,
                    'status'=>$this->status,
                    "created_at"=>$this->created_at->format('Y-m-d - H:i:s'),
                    "updated_at"=>$this->updated_at->format('Y-m-d - H:i:s')
                ]

            ];
    }
}
