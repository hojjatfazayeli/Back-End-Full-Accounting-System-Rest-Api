<?php

namespace App\Http\Resources;

use App\Models\Admin;
use App\Models\SubScriber;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $this->file !=null ? $file = env('APP_STORAGE').'/'.$this->file : $file=Null;


        if ($this->receiver_role == 'subscriber')
        {
            $rceiver = SubScriber::find($this->receiver_id);
            $sender = Admin::find($this->sender_id);
        }
        else
        {
            $rceiver = Admin::find($this->receiver_id);
            $sender = SubScriber::find($this->sender_id);
        }
        $sender->avatar !=null ? $sender_avatar = env('APP_STORAGE').'/'.$sender->avatar : $sender_avatar=Null;
        $rceiver->avatar !=null ? $receiver_avatar = env('APP_STORAGE').'/'.$rceiver->avatar : $receiver_avatar=Null;


        return
            [
                'sender' =>
                    [
                        'id' => $sender->id,
                        'role' => $sender->role,
                        'fullname' => $sender->firstname.' '.$sender->lastname,
                        'avatar' => $sender_avatar
                    ],
                'receiver' =>
                    [
                        'id' => $rceiver->id,
                        'role' => $rceiver->role,
                        'fullname' => $rceiver->firstname.' '.$rceiver->lastname,
                        'avatar' => $receiver_avatar
                    ],
                'message' =>
                    [
                        'id'=>$this->id,
                        'uuid'=>$this->uuid,
                        'message'=>$this->message,
                        'file'=>$file
                    ],
                'message_box' => $this->message_box
            ];
    }
}
