<?php

namespace App\Http\Controllers\AdminPanel\FiscalYearItem;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteFiscalYearRequest;
use App\Http\Requests\FiscalYearItemStoreRequest;
use App\Http\Requests\FiscalYearItemUpdateRequest;
use App\Http\Requests\FiscalYearStoreRequest;
use App\Http\Resources\FiscalYearItemInfoResource;
use App\Http\Resources\FiscalYearItemResource;
use App\Http\Resources\FiscalYearResource;
use App\Http\Resources\ReportResource;
use App\Models\Admin;
use App\Models\FiscalYear;
use App\Models\FiscalYearsItem;
use App\Models\ReportSystem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Webpatser\Uuid\Uuid;

class FiscalYearsItemController extends Controller
{

    public function index(Request $request,FiscalYear $fiscalYear)
    {
        $fiscal_years_item = $fiscalYear->fiscal_year_item();
        if ($request->has('orderby'))
        {
            $fiscal_years_item = $fiscal_years_item->orderBy('id',$request->orderby);
        }
        if ($request->has('amount_membershipـright_month'))
        {
            $fiscal_years_item = $fiscal_years_item->where('amount_membershipـright_month',$request->amount_membershipـright_month);
        }
        if ($request->has('amount_participate_right'))
        {
            $fiscal_years_item = $fiscal_years_item->where('amount_participate_right',$request->amount_participate_right);
        }
        if ($request->has('amount_membership_fee'))
        {
            $fiscal_years_item = $fiscal_years_item->where('amount_membership_fee',$request->amount_membership_fee);
        }
        if ($request->has('amount_motivational'))
        {
            $fiscal_years_item = $fiscal_years_item->where('amount_motivational',$request->amount_motivational);
        }
        if ($request->has('status'))
        {
            $fiscal_years_item = $fiscal_years_item->where('status',$request->status);
        }
        if ($request->has('perpage'))
        {
            $fiscal_years_item = $fiscal_years_item->paginate($request->perpage);
            $report = 'no';
            return response()->json([
                "message" => 'لیست شاخص های سال مالی باموفقیت دریافت شد',
                "report" =>$report,
                "data"=>FiscalYearItemResource::collection($fiscal_years_item)->response()->getData()
            ], 200);
        }
        else
        {
            $fiscal_years_item = $fiscal_years_item->get();
            $report = $this->reportLog('لیست شاخص های سال مالی');
            $report = new ReportResource($report);
            return response()->json([
                "message" => 'لیست شاخص های سال مالی باموفقیت دریافت شد',
                "report" =>$report,
                "data"=>FiscalYearItemResource::collection($fiscal_years_item)->response()->getOriginalContent()
            ], 200);
        }


    }
    public function store(FiscalYearItemStoreRequest $fiscalYearItemStoreRequest , FiscalYear $fiscalYear)
    {
        $creator = Admin::find(Auth::user()->id);
        $fiscalYearItemStoreRequest['fiscal_year_id'] = $fiscalYear->id;
        $fiscal_year_item = $creator->fiscal_year_item()->create($fiscalYearItemStoreRequest->all());
        return response()->json([
            "message" => 'شاخص های محاسباتی سال مالی با موفقیت ایجاد شد',
            "data"=>new FiscalYearResource($fiscalYear)
        ], 200);
    }
    public function show(FiscalYearsItem $fiscalYearsItem)
    {
        return response()->json([
            "message" => 'اطلاعات شاخص محاسباتی با موفقیت دریافت شد',
            "data"=>new FiscalYearItemInfoResource($fiscalYearsItem)
        ], 200);
    }
    public function update(FiscalYearItemUpdateRequest $fiscalYearItemUpdateRequest , FiscalYearsItem $fiscalYearsItem)
    {
        $fiscalYearsItem->update($fiscalYearItemUpdateRequest->all());
        return response()->json([
            "message" => 'اطلاعات شاخص محاسباتی با موفقیت بروزرسانی شد',
            "data"=>new FiscalYearItemInfoResource($fiscalYearsItem)
        ], 200);
    }
    public function delete(DeleteFiscalYearRequest $deleteFiscalYearRequest)
    {
        $items = explode(',',$deleteFiscalYearRequest->items);
        foreach ($items as $item)
        {
            $fiscal_year_item = FiscalYearsItem::find($item);
            $fiscal_year_item ? $fiscal_year_item->delete() : false;
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
