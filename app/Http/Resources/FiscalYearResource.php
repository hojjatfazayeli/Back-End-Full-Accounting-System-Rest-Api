<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FiscalYearResource extends JsonResource
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
                'creator'=> $this->admin,
                'fiscal_year' =>
                [
                    'id'=>$this->id,
                    'uuid'=>$this->uuid,
                    'title'=>$this->title,
                    'year'=>$this->year,
                    'start_date'=>$this->start_date,
                    'end_date'=>$this->end_date,
                    'status'=>$this->status,
                    "created_at"=>$this->created_at->format('Y-m-d - H:i:s'),
                    "updated_at"=>$this->updated_at->format('Y-m-d - H:i:s')
                ],
                'fiscal_year_item' => $this->fiscal_year_item
            ];
    }
}
