<?php

namespace App\Http\Controllers\AdminPanel\ChequeSheet;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChequeSheetUpdateRequest;
use App\Http\Resources\ChequeInfoResource;
use App\Http\Resources\ChequeSheetInfoResource;
use App\Http\Resources\ChequeSheetResource;
use App\Http\Resources\ReportResource;
use App\Models\Cheque;
use App\Models\ChequeSheet;
use App\Models\ReportSystem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Webpatser\Uuid\Uuid;

class ChequeSheetController extends Controller
{

    public function show(ChequeSheet $chequeSheet)
    {
        return response()->json([
            "message" => 'برگ چک موردنظر با موفقیت دریافت شد',
            "data"=>new ChequeSheetResource($chequeSheet)
        ], 200);
    }

    public function printChequeSheet(ChequeSheet $chequeSheet)
    {
        return response()->json([
            "message" => 'اطلاعات چاپ برگ چک به شرح ذیل است',
            "data"=>new ChequeSheetResource($chequeSheet)
        ], 200);
    }
    public function index(Request $request)
    {
        $cheque_sheets =  ChequeSheet::query()->where('cheque_id',$request->cheque_id);
        if ($request->has('orderby'))
        {
            $cheque_sheets = $cheque_sheets->orderBy('id',$request->orderby);
        }
        if ($request->has('cheque_number'))
        {
            $cheque_sheets = $cheque_sheets->where('cheque_number',$request->cheque_number);
        }
        if ($request->has('document_number'))
        {
            $cheque_sheets = $cheque_sheets->where('document_number',$request->document_number);
        }
        if ($request->has('series'))
        {
            $cheque_sheets = $cheque_sheets->where('series',$request->series);
        }
        if ($request->has('serial'))
        {
            $cheque_sheets = $cheque_sheets->where('serial',$request->serial);
        }
        if ($request->has('sayyad_id'))
        {
            $cheque_sheets = $cheque_sheets->where('sayyad_id',$request->sayyad_id);
        }
        if ($request->has('date'))
        {
            $cheque_sheets = $cheque_sheets->where('date',$request->date);
        }
        if ($request->has('amount'))
        {
            $cheque_sheets = $cheque_sheets->where('amount',$request->amount);
        }
        if ($request->has('national_code'))
        {
            $cheque_sheets = $cheque_sheets->where('national_code',$request->national_code);
        }
        if ($request->has('status'))
        {
            $cheque_sheets = $cheque_sheets->where('status',$request->status);
        }
        if ($request->has('creator_id'))
        {
            $cheque_sheets = $cheque_sheets->where('creator_id',$request->creator_id);
        }
        if ($request->has('bank_id'))
        {
            $cheque_sheets = $cheque_sheets->where('bank_id',$request->bank_id);
        }
        if ($request->has('description'))
        {
            $cheque_sheets = $cheque_sheets->where('description','LIKE','%'.$request->description.'%');
        }

        if ($request->has('perpage'))
        {
            $cheque_sheets = $cheque_sheets->paginate($request->perpage);
            $report = 'no';
        }
        else
        {
            $cheque_sheets = $cheque_sheets->get();
            $report = $this->reportLog('لیست چک');
            $report = new ReportResource($report);
        }
        return response()->json([
            "message" => 'لیست برگه چک های سامانه با موفقیت دریافت شد',
            "report" =>$report,
            "data"=>ChequeSheetResource::collection($cheque_sheets)->response()->getData()
        ], 200);

    }

    public function update(ChequeSheetUpdateRequest $chequeSheetUpdateRequest , ChequeSheet $chequeSheet)
    {
        $chequeSheetUpdateRequest['creator_id'] = Auth::user()->id;
        $chequeSheet->update($chequeSheetUpdateRequest->all());
        return response()->json([
            "message" => 'برگ چک موردنظر با موفقیت بروزرسانی شد',
            "data"=>new ChequeSheetResource($chequeSheet)
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
