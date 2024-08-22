<?php

namespace App\Http\Controllers\AdminPanel\Notification;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotificationStoreRequest;
use App\Http\Resources\NotificationInfoResource;
use App\Models\Notification;
use Illuminate\Support\Facades\Storage;
use Webpatser\Uuid\Uuid;

class NotificationController extends Controller
{
    public function send(NotificationStoreRequest $notificationStoreRequest)
    {
        $notification =  Notification::create($notificationStoreRequest->all());
        if ($notificationStoreRequest->has('file'))
        {
            $filePath = Storage::putFile('/notification' , $notificationStoreRequest->file);
            $notification->update(['file' => $filePath]);
        }

        return response()->json([
            "message" => 'پیام با موفقیت ارسال شد',
            "data"=>new NotificationInfoResource($notification)
        ], 200);
    }
}
