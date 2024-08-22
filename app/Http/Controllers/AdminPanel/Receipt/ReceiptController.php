<?php

namespace App\Http\Controllers\AdminPanel\Receipt;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReceiptStoreRequest;
use App\Http\Requests\ReceiptUpdateRequest;
use App\Http\Resources\ReceiptInfoResource;
use App\Http\Resources\ReportResource;
use App\Models\Receipt;
use App\Models\ReportSystem;
use App\Models\SubScriber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Webpatser\Uuid\Uuid;

class ReceiptController extends Controller
{

    public function index(Request $request)
    {
        $receipt = Receipt::query();
        if ($request->has('orderby'))
        {
            $receipt = $receipt->orderBy('id',$request->orderby);
        }
        if ($request->has('title'))
        {
            $receipt = $receipt->where('title','LIKE','%'.$request->title.'%');
        }
        if ($request->has('receipt_number'))
        {
            $receipt = $receipt->where('receipt_number',$request->receipt_number);
        }
        if ($request->has('deposit_date'))
        {
            $receipt = $receipt->where('deposit_date',$request->deposit_date);
        }
        if ($request->has('fiscal_document_id'))
        {
            $receipt = $receipt->where('fiscal_document_id',$request->fiscal_document_id);
        }
        if ($request->has('bank_list_id'))
        {
            $receipt = $receipt->where('bank_list_id',$request->bank_list_id);
        }
        if ($request->has('creator_id'))
        {
            $receipt = $receipt->where('creator_id',$request->creator_id);
        }
        if ($request->has('perpage'))
        {
            $receipt = $receipt->paginate($request->perpage);
            $report = 'no';
        }
        else
        {
            $receipt = $receipt->get();
            $report = $this->reportLog('لیست فیش های بانکی');
            $report = new ReportResource($report);
        }
        return response()->json([
            "message" => 'لیست فیش های بانکی با موفقیت دریافت گردید',
            "report" =>$report,
            "data"=>ReceiptInfoResource::collection($receipt)->response()->getData()
        ], 200);
    }
    public function store(ReceiptStoreRequest $receiptStoreRequest)
    {
        $receipt = Receipt::create($receiptStoreRequest->all());
        if ($receiptStoreRequest->hasFile('file'))
        {
            $receipthPath = Storage::putFile('/receipt' , $receiptStoreRequest->file);
            $receipt->update(['file' => $receipthPath]);
        }
        return response()->json([
            "message" => 'فیش بانکی با موفقیت ثبت گردید',
            "data"=> new ReceiptInfoResource($receipt)
        ], 200);
    }

    public function show(Receipt $receipt)
    {
        return response()->json([
            "message" => 'فیش بانکی با موفقیت دریافت گردید',
            "data"=> new ReceiptInfoResource($receipt)
        ], 200);
    }
    public function update(ReceiptUpdateRequest $receiptUpdateRequest , Receipt $receipt)
    {
        $receipt->update($receiptUpdateRequest->all());
        if ($receiptUpdateRequest->has('file'))
        {
            Storage::delete($receipt->file);
            $receipthPath = Storage::putFile('/receipt' , $receiptUpdateRequest->file);
            $receipt->update(['file' => $receipthPath]);
        }
        return response()->json([
            "message" => 'فیش بانکی با موفقیت بروزرسانی گردید',
            "data"=> new ReceiptInfoResource($receipt)
        ], 200);
    }

    public function autoDestroy(Request $request)
    {
        $items = explode(',',$request->items);
        foreach ($items as $item)
        {
            $item = Receipt::find($item);
            $item ? $item->delete(): false;

        }
        return response()->json([
            "message" => 'حذف با موفقیت انجام شد',
        ], 200);
    }

    public function reportLog($reportname)
    {
        $currentTime = Carbon::now();
        $time = $currentTime->format('H:i:s');
        $date = $currentTime->format('Y-m-d');
        $reportData =  ReportSystem::create([
            'uuid'=>Uuid::generate()->string,
            'type'=>$reportname,
            'receiver_report_id'=>Auth::user()->id,
            'role'=>'admin',
            'data'=>$date,
            'time'=>$time,
            'row'=>mt_rand('11111','99999')
        ]);

        return $reportData;
    }
}
