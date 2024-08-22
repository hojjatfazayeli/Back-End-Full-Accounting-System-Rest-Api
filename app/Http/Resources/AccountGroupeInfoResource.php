<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountGroupeInfoResource extends JsonResource
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
                'creator' =>new AdminInfoResource($this->admin),
                'group_account' =>
                [
                    'id'=>$this->id,
                    'uuid'=>$this->uuid,
                    'fiscal_year'=>$this->fiscal_year,
                    'title'=>$this->title,
                    'total_code'=>$this->total_code,
                    'type_account'=>$this->type_account,
                    'nature_account'=>$this->nature_account,
                    'status_account'=>$this->status_account,
                    "created_at"=>$this->created_at->format('Y-m-d - H:i:s'),
                    "updated_at"=>$this->updated_at->format('Y-m-d - H:i:s')
                ]
            ];
    }
}
