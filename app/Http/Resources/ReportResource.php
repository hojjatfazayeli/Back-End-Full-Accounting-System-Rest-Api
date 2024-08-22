<?php

namespace App\Http\Resources;

use App\Models\Admin;
use App\Models\SubScriber;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $this->role == 'admin' ? $user = Admin::find($this->receiver_report_id) : $user = SubScriber::find($this->receiver_report_id);
        return
            [
                'id'=>$this->id,
                'uuid'=>$this->uuid,
                'type'=>$this->type,
                'creator'=> $user->firstname.' '.$user->lastname,
                'number'=>$this->row,
                'row'=>$this->id,
                'date'=>$this->created_at,
                'time'=>$this->time,

            ];
    }
}
