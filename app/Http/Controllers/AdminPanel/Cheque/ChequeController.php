<?php

namespace App\Http\Controllers\AdminPanel\Cheque;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChequeStoreRequest;
use App\Http\Requests\ChequeUpdateRequest;
use App\Http\Resources\AdminInfoResource;
use App\Http\Resources\ChequeInfoResource;
use App\Http\Resources\ChequeSheetInfoResource;
use App\Http\Resources\ReportResource;
use App\Models\Account;
use App\Models\Cheque;
use App\Models\ChequeSheet;
use App\Models\ReportSystem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Webpatser\Uuid\Uuid;

class ChequeController extends Controller
{
    public function index(Request $request)
    {
        $cheques = Cheque::query();
        if ($request->has('orderby'))
        {
            $cheques = $cheques->orderBy('id',$request->orderby);
        }
        if ($request->has('bank_id'))
        {
            $cheques = $cheques->where('bank_id',$request->bank_id);
        }
        if ($request->has('date_received'))
        {
            $cheques = $cheques->where('date_received',$request->date_received);
        }
        if ($request->has('description'))
        {
            $cheques = $cheques->where('description','LIKE','%'.$request->description.'%');
        }
        if ($request->has('status'))
        {
            $cheques = $cheques->where('status',$request->status);
        }
        if ($request->has('perpage'))
        {
            $cheques = $cheques->paginate($request->perpage);
            $report = 'no';
        }
        else
        {
            $cheques = $cheques->get();
            $report = $this->reportLog('لیست چک');
            $report = new ReportResource($report);
        }
        return response()->json([
            "message" => 'لیست دسته چک ها باموفقیت دریافت شد',
            "report" =>$report,
            "data"=>ChequeInfoResource::collection($cheques)->response()->getData()
        ], 200);
    }
    public function chequeSheetList(Request $request , Cheque $cheque)
    {
       $cheque_sheets =  $cheque->cheque_sheets();
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
            $report = $this->reportLog('لیست برگ چک');
            $report = new ReportResource($report);

        }
        return response()->json([
            "message" => 'لیست برگه چک های دسته چک با موفقیت دریافت شد',
            "report" =>$report,
            "data"=>ChequeSheetInfoResource::collection($cheque_sheets)->response()->getData()
        ], 200);

    }
    public function show(Cheque $cheque)
    {
        return response()->json([
            "message" => 'اطلاعات چک باموفقیت دریافت شد',
            "data"=>new ChequeInfoResource($cheque)
        ], 200);
    }
    public function store(ChequeStoreRequest $chequeStoreRequest)
    {
        if ($chequeStoreRequest->number_first_sheet + ($chequeStoreRequest->number_sheet-1) != $chequeStoreRequest->number_last_sheet)
        {
            return response()->json([
                "message" => 'شماره آخرین برگ چک اشتباه هست',
            ], 318);
        }

        if ($chequeStoreRequest->number_last_sheet - ($chequeStoreRequest->number_first_sheet-1) != $chequeStoreRequest->number_sheet)
        {
            return response()->json([
                "message" => 'تعداد برگ چک اعلامی اشتباه است',
            ], 318);
        }
        if ($chequeStoreRequest->number_last_sheet-($chequeStoreRequest->number_sheet-1) != $chequeStoreRequest->number_first_sheet)
        {
            return response()->json([
                "message" => 'شماره اولین برگ چک اشتباه است',
            ], 318);
        }
        $cheque = auth()->user()->cheque()->create($chequeStoreRequest->all());
        for($i = $chequeStoreRequest->number_first_sheet ; $i <= $chequeStoreRequest->number_last_sheet ; $i++)
        {
                $cheque->cheque_sheets()->create([
                    'cheque_number'=> $i,
                    'bank_id'=> $chequeStoreRequest->bank_id
                ]);
        }
        return response()->json([
            "message" => 'دسته چک بانکی با موفقیت تعریف شد',
            "data"=>new ChequeInfoResource($cheque)
        ], 200);
    }
    public function update(ChequeUpdateRequest $chequeUpdateRequest , Cheque $cheque)
    {
       $cheque_sheets =  ChequeSheet::where('cheque_id',$cheque->id)->get();
       if ($chequeUpdateRequest->has('number_first_sheet') or $chequeUpdateRequest->has('number_last_sheet') or $chequeUpdateRequest->has('number_sheet'))
       {
           foreach ($cheque_sheets as $cheque_sheet)
           {
               if ($cheque_sheet->status == '2' or $cheque_sheet->status == '3')
               {
                   return response()->json([
                       "message" => 'متاسفانه به دلیل استفاده شدن برگ چک از این دسته چک امکان تغییر شماره چک وجود ندارد',
                   ], 318);
               }
           }
           $cheque_sheets->map->delete();

           if ($chequeUpdateRequest->number_first_sheet + ($chequeUpdateRequest->number_sheet) != $chequeUpdateRequest->number_last_sheet)
           {
               return response()->json([
                   "message" => 'شماره آخرین برگ چک اشتباه هست',
               ], 318);
           }

           if ($chequeUpdateRequest->number_last_sheet - $chequeUpdateRequest->number_first_sheet != $chequeUpdateRequest->number_sheet)
           {
               return response()->json([
                   "message" => 'تعداد برگ چک اعلامی اشتباه است',
               ], 318);
           }
           if ($chequeUpdateRequest->number_last_sheet-$chequeUpdateRequest->number_sheet != $chequeUpdateRequest->number_first_sheet)
           {
               return response()->json([
                   "message" => 'شماره اولین بگ چک اشتباه است',
               ], 318);
           }
           for($i = $chequeUpdateRequest->number_first_sheet ; $i <= $chequeUpdateRequest->number_last_sheet ; $i++)
           {
               $cheque->cheque_sheets()->create([
                   'cheque_number'=> $i,
                   'bank_id'=> $chequeUpdateRequest->bank_id
               ]);
           }
       }
       $cheque->update($chequeUpdateRequest->all());
        return response()->json([
            "message" => 'دسته چک بانکی با موفقیت بروزرسانی شد',
            "data"=>new ChequeInfoResource($cheque)
        ], 200);

    }
    public function delete(Request $request)
    {
        $items = explode(',',$request->items);
        foreach ($items as $item)
        {
            $cheque = Cheque::find($item);
            $cheque_sheet = $cheque->cheque_sheets()->where('status','!=','1')->first();
            if ($cheque_sheet)
            {
                return response()->json([
                    "message" => 'متاسفانه به دلیل استفاده برگ چک از این دسته چک امکان حذف وجود ندارد',
                ], 200);
            }
            $cheque ? $cheque->delete() : false;
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
            'role'=>Auth::user()->role,
            'data'=>$date,
            'time'=>$time,
            'row'=>mt_rand('11111','99999')
        ]);

        return $reportData;
    }

}
