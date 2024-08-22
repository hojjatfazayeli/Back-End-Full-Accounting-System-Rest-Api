<?php

namespace App\Http\Resources;

use App\Models\Admin;
use App\Models\Buyer;
use App\Models\Seller;
use App\Models\SubScriber;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->reciever_id)
        {
            if ($this->role == 'subscriber')
            {
                $reciever = SubScriber::find($this->reciever_id);
                $sender = Admin::find($this->sender_id);
                $receiver_info = new SubScriberInfoResource($reciever);
                $sender_info = new AdminInfoResource($sender);
            }
            else
            {
                $reciever = Admin::find($this->reciever_id);
                $sender = SubScriber::find($this->sender_id);
                $receiver_info = new AdminInfoResource($reciever);
                $sender_info = new SubScriberInfoResource($sender);
            }
        }
        return
            [
                'sender' => $sender_info,
                'receiver' => $receiver_info,
                'message' =>
                    [
                        'id'=>$this->id,
                        'uuid'=>$this->uuid,
                        'title'=>$this->title,
                        'description'=>$this->description,
                        'file'=>env('APP_STORAGE').'/'.$this->file
                    ]
            ];
    }
}
