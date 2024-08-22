<?php

namespace App\Http\Controllers\AdminPanel\InstallmentBooklet;

use App\Http\Controllers\Controller;
use App\Http\Requests\InstallmentBookletStoreRequest;
use App\Http\Requests\InstallmentBookletUpdateRequest;
use App\Http\Resources\ActiveFiscalYearResource;
use App\Http\Resources\FacilityResource;
use App\Http\Resources\InstallmentBookletResource;
use App\Http\Resources\ReportResource;
use App\Models\Facilities;
use App\Models\InstallmentBooklet;
use App\Models\ReportSystem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Webpatser\Uuid\Uuid;

class InstallmentBookletController extends Controller
{

    public function index(Request $request , Facilities $facilities)
    {
        $installments = $facilities->installment_booklet();
        if ($request->has('orderby'))
        {
            $installments = $installments->orderBy('id','asc');
        }
        if ($request->has('creator_id'))
        {
            $installments = $installments->where('creator_id',$request->creator_id);
        }
        if ($request->has('nature_installment'))
        {
            $installments = $installments->where('nature_installment',$request->nature_installment);
        }
        if ($request->has('type_installment'))
        {
            $installments = $installments->where('type_installment',$request->type_installment);
        }
        if ($request->has('payment_year'))
        {
            $installments = $installments->where('payment_year',$request->payment_year);
        }
        if ($request->has('payment_month'))
        {
            $installments = $installments->where('payment_month',$request->payment_month);
        }
        if ($request->has('amount_installment'))
        {
            $installments = $installments->where('amount_installment',$request->amount_installment);
        }
        if ($request->has('fiscal_year'))
        {
            $installments = $installments->where('fiscal_year',$request->fiscal_year);
        }
        if ($request->has('fiscal_month'))
        {
            $installments = $installments->where('fiscal_month',$request->fiscal_month);
        }
        if ($request->has('perpage'))
        {
            $installments = $installments->paginate($request->perpage);
            $report = 'no';
        }
        else
        {
            $installments = $installments->get();
            $report = $this->reportLog('لیست اقساط تسهیلات');
            $report = new ReportResource($report);

        }
        return response()->json([
            "message" => 'لیست اقساط تسهیلات باموفقیت دریافت شد',
            "report" =>$report,
            "data"=>InstallmentBookletResource::collection($installments)->response()->getData()
        ], 200);
    }
    public function store(InstallmentBookletStoreRequest $installmentBookletStoreRequest,Facilities $facilities)
    {
        $sum_amount_installment = $facilities->installment_booklet()->sum('amount_installment') + $installmentBookletStoreRequest->amount_installment;
        if ($sum_amount_installment - $facilities->amount_facility > 0)
        {
            return response()->json([
                "message" => ' مجموع مبالغ اقساط تسهیلات مورد نظر از مبلغ تسهیلات بیشتر است. لطفا مبلغ قسط را اصلاح فرمایید',
            ], 200);
        }
        $installmentBookletStoreRequest['creator_id'] = Auth::user()->id;
        $installment = $facilities->installment_booklet()->create($installmentBookletStoreRequest->all());
        return response()->json([
            "message" => 'قسط جدید تسهیلات با موفقیت ایجاد شد',
            "data" => new FacilityResource($facilities)
        ], 200);
    }

    public function update(InstallmentBookletUpdateRequest $installmentBookletUpdateRequest , InstallmentBooklet $installmentBooklet)
    {
        $facilities = $installmentBooklet->facility()->first();
        $sum_amount_installment = ($facilities->installment_booklet()->sum('amount_installment') - $installmentBooklet->amount_installment) + $installmentBookletUpdateRequest->amount_installment;
        if ($sum_amount_installment - $facilities->amount_facility > 0)
        {
            return response()->json([
                "message" => ' مجموع مبالغ اقساط تسهیلات مورد نظر از مبلغ تسهیلات بیشتر است. لطفا مبلغ قسط را اصلاح فرمایید',
            ], 200);
        }
        $installmentBooklet->update($installmentBookletUpdateRequest->all());
        return response()->json([
            "message" => 'قسط تسهیلات با موفقیت بروزرسانی شد',
            "data" => new FacilityResource($facilities)
        ], 200);
    }

    public function show(InstallmentBooklet $installmentBooklet)
    {
        return response()->json([
            "message" => 'اطلاعات قسط تسهیلات باموفقیت دریافت شد',
            "data"=>new InstallmentBookletResource($installmentBooklet)
        ], 200);
    }

    public function delete(Request $request)
    {
        $items = explode(',',$request->items);
        foreach ($items as $item)
        {
            $installment_booklet = InstallmentBooklet::find($item);
                if ($installment_booklet and $installment_booklet->status == 'paid')
                {
                    return response()->json([
                        "message" => 'به دلیل انجام تراکنش پرداخت برای این قسط امکان حذف وجود ندارد',
                    ], 200);
                }
                $installment_booklet ? $installment_booklet->delete() : false;
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
