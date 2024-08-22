<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChequeInfoResource extends JsonResource
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
                'bank'=>$this->bank,
                'account'=>$this->account,
                'cheque'=>
                [
                    'id'=>$this->id,
                    'uuid'=>$this->uuid,
                    'number_first_sheet'=>$this->number_first_sheet,
                    'number_last_sheet'=>$this->number_last_sheet,
                    'number_sheet'=>$this->number_sheet,
                    'date_received'=>$this->date_received,
                    'description'=>$this->description,
                    'status'=>$this->status,
                    "created_at"=>$this->created_at->format('Y-m-d - H:i:s'),
                    "updated_at"=>$this->updated_at->format('Y-m-d - H:i:s'),
                ]
            ];
    }
}
