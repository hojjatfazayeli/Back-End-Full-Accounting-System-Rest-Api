<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FiscalDocumentItemResource extends JsonResource
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
                'item' =>
                [
                    'id'=> $this->id,
                    'uuid' => $this->uuid,
                    'description' => $this->description,
                    'deptor' => $this->deptor,
                    'creditor' => $this->creditor,
                    'fiscal_year' => $this->fiscal_year,
                    'fiscal_month' => $this->fiscal_month,
                    'status' => $this->status,
                    "created_at"=>$this->created_at->format('Y-m-d - H:i:s'),
                    "updated_at"=>$this->updated_at->format('Y-m-d - H:i:s')
                ],
                'account' => $this->account
            ];
    }
}
