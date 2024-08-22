<?php

namespace App\Http\Resources;

use App\Models\Admin;
use App\Models\SubScriber;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageBoxListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

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
        $rceiver = SubScriber::find($this->receiver_id);
        $sender = Admin::find($this->sender_id);
        $sender->avatar !=null ? $sender_avatar = env('APP_STORAGE').'/'.$sender->avatar : $sender_avatar=Null;
        $rceiver->avatar !=null ? $receiver_avatar = env('APP_STORAGE').'/'.$rceiver->avatar : $receiver_avatar=Null;
		$unseen_status = $this->messages()->where('status' , 'unseen')->get();

        return
            [
                'id' => $this->id,
				'number_unseen_status' => count($unseen_status),
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
                    ]
            ];

    }
}
