<?php

namespace App\Http\Controllers\AdminPanel\MessageBox;

use App\Http\Controllers\Controller;
use App\Http\Resources\MessageBoxListResource;
use App\Http\Resources\MessageBoxResource;
use App\Models\MessageBox;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class MessageBoxController extends Controller
{
    public function index(Request $request)
    {
        $messagebox_list_one = MessageBox::where('sender_id' , Auth::user()->id)->where('sender_role' , Auth::user()->role)->get();
        $messagebox_list_two = MessageBox::where('receiver_id' , Auth::user()->id)->where('receiver_role' , Auth::user()->role)->get();
        if ($messagebox_list_one != null or $messagebox_list_two!= null) {

            return response()->json([
                "message" => 'لیست مکالمات انجام شده کاربر با موفقیت دریافت شد',
                "messagebox_list_one" => MessageBoxListResource::collection($messagebox_list_one),
                "messagebox_list_two" => MessageBoxListResource::collection($messagebox_list_two)
            ], 200);
        } else
        {
            return response()->json([
                "message" => 'هیچ مکالمه‌ای یافت نشد',
                "data" => []
            ], 200);
        }
    }
    public function show(MessageBox $messageBox)
    {
        return response()->json([
            "message" => 'لیست پیام ها باموفقیت دریافت شد',
            "data"=>new MessageBoxResource($messageBox)
        ], 200);
    }
}
