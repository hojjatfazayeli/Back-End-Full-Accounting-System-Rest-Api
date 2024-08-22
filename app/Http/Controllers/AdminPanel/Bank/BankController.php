<?php

namespace App\Http\Controllers\AdminPanel\Bank;

use App\Http\Controllers\Controller;
use App\Http\Resources\AccountInfoResource;
use App\Models\Bank;

class BankController extends Controller
{
    public function index()
    {
       $bank =  Bank::all();
        return response()->json([
            "message" => 'لیست اطلاعات بانک ها با موفقیت دریافت شد',
            "data"=>$bank
        ], 200);
    }
}
