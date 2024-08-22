<?php

namespace App\Http\Controllers\AdminPanel\FiscalYear;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeStatusFiscalRequest;
use App\Http\Requests\DeleteFiscalYearRequest;
use App\Http\Requests\FiscalYearStoreRequest;
use App\Http\Requests\FiscalYearUpdateRequest;
use App\Http\Resources\ActiveFiscalYearResource;
use App\Http\Resources\ChequeInfoResource;
use App\Http\Resources\FiscalYearResource;
use App\Http\Resources\ReportResource;
use App\Models\Account;
use App\Models\Admin;
use App\Models\Cheque;
use App\Models\FiscalYear;
use App\Models\FiscalYearsItem;
use App\Models\ReportSystem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Webpatser\Uuid\Uuid;

class FiscalYearController extends Controller
{

    public function index(Request $request)
    {
        $fiscal_year = FiscalYear::query();
        if ($request->has('orderby'))
        {
            $fiscal_year = $fiscal_year->orderBy('id',$request->orderby);
        }
        if ($request->has('title'))
        {
            $fiscal_year = $fiscal_year->where('title','LIKE','%'.$request->title.'%');
        }
        if ($request->has('yaer'))
        {
            $fiscal_year = $fiscal_year->where('yaer',$request->yaer);
        }
        if ($request->has('perpage'))
        {
            $fiscal_year = $fiscal_year->paginate($request->perpage);
            $report = 'no';
        }
        else
        {
            $fiscal_year = $fiscal_year->get();
            $report = $this->reportLog('لیست سال مالی');
            $report = new ReportResource($report);

        }
        return response()->json([
            "message" => 'لیست سال مالی باموفقیت دریافت شد',
            "report" =>$report,
            "data"=>FiscalYearResource::collection($fiscal_year)->response()->getData()
        ], 200);
    }
    public function store(FiscalYearStoreRequest $fiscalYearStoreRequest)
    {
        $creator = Admin::find(Auth::user()->id);
        $fiscal_year = $creator->fiscal_year()->create($fiscalYearStoreRequest->all());
        return response()->json([
            "message" => 'سال مالی باموفقیت ایجاد شد',
            "data"=>new FiscalYearResource($fiscal_year)
        ], 200);
    }

    public function show(FiscalYear $fiscalYear)
    {
        return response()->json([
            "message" => 'اطلاعات سال مالی با موفقیت دریافت شد',
            "data"=>new FiscalYearResource($fiscalYear)
        ], 200);
    }

    public function update(FiscalYearUpdateRequest $fiscalYearUpdateRequest , FiscalYear $fiscalYear)
    {
        $fiscalYear->update($fiscalYearUpdateRequest->all());
        return response()->json([
            "message" => 'اطلاعات سال مالی با موفقیت بروزرسانی شد',
            "data"=>new FiscalYearResource($fiscalYear)
        ], 200);
    }

    public function delete(DeleteFiscalYearRequest $deleteFiscalYearRequest)
    {
        $items = explode(',',$deleteFiscalYearRequest->items);
        foreach ($items as $item)
        {
            $fiscal_year = FiscalYear::find($item);
            if (count($fiscal_year->fiscal_year_item()->get()) > 0)
            {
                return response()->json([
                    "message" => 'به دلیل تخصیص شاخص مالی به اطلاعات سال مالی مذکور امکان حذف وجود ندارد',
                ], 200);
            }
            $fiscal_year ? $fiscal_year->delete() : false;
        }
        return response()->json([
            "message" => 'حذف با موفقیت انجام شد',
        ], 200);
    }

    public function update_status(ChangeStatusFiscalRequest $changeStatusFiscalRequest)
    {
        $fiscal_years = FiscalYear::all();
        $fiscal_year_items = FiscalYearsItem::all();
        foreach ($fiscal_years as $fiscal_year)
        {
            $fiscal_year->update(['status'=>'deactive']);
        }
        foreach ($fiscal_year_items as $fiscal_year_item)
        {
            $fiscal_year_item->update(['status'=>'deactive']);
        }
        FiscalYear::where('id',$changeStatusFiscalRequest->fiscal_year_id)->update(['status' => $changeStatusFiscalRequest->fiscal_year_status]);
        FiscalYearsItem::where('id',$changeStatusFiscalRequest->fiscal_years_item_id)->update(['status' => $changeStatusFiscalRequest->fiscal_years_item_status]);
        $active_fiscal_year = FiscalYear::where('status','active')->first();
        return response()->json([
            "message" => 'سال مالی با موفقیت بروزرسانی گردید',
            "data" => new ActiveFiscalYearResource($active_fiscal_year)
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
