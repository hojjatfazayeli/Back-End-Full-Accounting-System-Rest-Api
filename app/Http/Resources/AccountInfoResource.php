<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountInfoResource extends JsonResource
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
                'group_account'=> $this->account_groupe,
                'account' =>
                    [
                        'id'=>$this->id,
                        'uuid'=>$this->uuid,
                        'title'=>$this->title,
                        'total_code'=>$this->totalcode,
                        'specificcode'=>$this->specificcode,
                        'detailedcode'=>$this->detailedcode,
                        'need_entity'=>$this->need_entity,
                        'status_account'=>$this->status_account,
                        "created_at"=>$this->created_at->format('Y-m-d - H:i:s'),
                        "updated_at"=>$this->updated_at->format('Y-m-d - H:i:s')
                    ]
            ];
    }
}
