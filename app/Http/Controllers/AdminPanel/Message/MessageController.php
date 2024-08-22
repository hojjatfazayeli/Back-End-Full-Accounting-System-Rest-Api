<?php

namespace App\Http\Controllers\AdminPanel\Message;

use App\Http\Controllers\Controller;
use App\Http\Requests\MessageStoreRequest;
use App\Http\Resources\MessageBoxResource;
use App\Http\Resources\MessageInfoResource;
use App\Models\Message;
use App\Models\MessageBox;
use App\Models\Admin;
use App\Models\SubScriber;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Pusher\Pusher;

class MessageController extends Controller
{
    public function send(MessageStoreRequest $messageStoreRequest)
    {
		if($messageStoreRequest->type == 'broadcast')
		{
			$message = $this->broadcast_message($messageStoreRequest->message , $messageStoreRequest->file);
			return response()->json([
            "message" => 'اعلان عمومی با موفقیت ارسال گردید',
        ], 200);
		}
        $message_box = MessageBox::where('sender_id' , $messageStoreRequest->receiver_id)->where('sender_role' , $messageStoreRequest->receiver_role)->where('receiver_id' , Auth::user()->id)->where('receiver_role' , Auth::user()->role)->first();
        if (!$message_box)
       {
           $message_box = MessageBox::where('sender_id' , Auth::user()->id)->where('sender_role' , Auth::user()->role)->where('receiver_id' , $messageStoreRequest->receiver_id)->where('receiver_role' , $messageStoreRequest->receiver_role)->first();
           if (!$message_box)
           {
               $message_box =  MessageBox::create($messageStoreRequest->all());
           }
       }
        $message = $message_box->messages()->create($messageStoreRequest->all());
        if ($messageStoreRequest->has('file'))
        {
            $filePath = Storage::putFile('/message' , $messageStoreRequest->file);
            $message->update(['file' => $filePath]);
        }
        if ($messageStoreRequest->receiver_role == 'subscriber')
        {
            $rceiver = SubScriber::find($messageStoreRequest->receiver_id);
            $sender = Admin::find(Auth::user()->id);
        }
        else
        {
            $rceiver = Admin::find($messageStoreRequest->receiver_id);
            $sender = SubScriber::find(Auth::user()->id);
        }
		$message->file !=null ? $file = env('APP_STORAGE').'/'.$message->file : $file=Null;
        $sender->avatar !=null ? $sender_avatar = env('APP_STORAGE').'/'.$sender->avatar : $sender_avatar=Null;
        $rceiver->avatar !=null ? $receiver_avatar = env('APP_STORAGE').'/'.$rceiver->avatar : $receiver_avatar=Null;
        $pusher = new Pusher("186aebe912003e50c14b", "885dd3e4fb6647700810", "1718535", array('cluster' => 'eu'));
        $pusher->trigger('my-channel', 'my-event', array([
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
                        'id'=>$message->id,
                        'uuid'=>$message->uuid,
                        'message'=>$message->message,
                        'file'=>$file
                    ]
            ]));
        return response()->json([
            "message" => 'پیام با موفقیت ارسال گردید',
            "data"=>new MessageBoxResource($message_box)
        ], 200);
    }


	public function broadcast_message($message , $file)
	{
		$subscribers = SubScriber::all();
        if ($file)
        {
            $filePath = Storage::putFile('/message' , $file);
        }
		else
		{
			$filePath = Null;
		}

		foreach($subscribers as $subscriber)
		{

        $message_box = MessageBox::where('sender_id' , $subscriber->id)->where('sender_role' , $subscriber->role)->where('receiver_id' , Auth::user()->id)->where('receiver_role' , Auth::user()->role)->first();
        if (!$message_box)
       {
           $message_box = MessageBox::where('sender_id' , Auth::user()->id)->where('sender_role' , Auth::user()->role)->where('receiver_id' , $subscriber->id)->where('receiver_role' , $subscriber->role)->first();
           if (!$message_box)
           {
               $message_box =  MessageBox::create([
				   'sender_role' => Auth::user()->role,
				   'sender_id' => Auth::user()->id,
				   'receiver_role' => $subscriber->role,
				   'receiver_id' => $subscriber->id
			   ]);
           }
       }
        $message = $message_box->messages()->create([
				   'message' => $message,
				   'sender_role' => Auth::user()->role,
				   'sender_id' => Auth::user()->id,
				   'receiver_role' => $subscriber->role,
				   'receiver_id' => $subscriber->id,
				   'file' => $filePath
				   		]);
        if ($subscriber->role == 'subscriber')
        {
            $rceiver = SubScriber::find($subscriber->id);
            $sender = Admin::find(Auth::user()->id);
        }
		$message->file !=null ? $file = env('APP_STORAGE').'/'.$message->file : $file=Null;
        $sender->avatar !=null ? $sender_avatar = env('APP_STORAGE').'/'.$sender->avatar : $sender_avatar=Null;
        $rceiver->avatar !=null ? $receiver_avatar = env('APP_STORAGE').'/'.$rceiver->avatar : $receiver_avatar=Null;
        $pusher = new Pusher("186aebe912003e50c14b", "885dd3e4fb6647700810", "1718535", array('cluster' => 'eu'));
        $pusher->trigger('my-channel', 'my-event', array([
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
                        'id'=>$message->id,
                        'uuid'=>$message->uuid,
                        'message'=>$message->message,
                        'file'=>$file
                    ]
            ]));
		return true;


	}
	}

}
