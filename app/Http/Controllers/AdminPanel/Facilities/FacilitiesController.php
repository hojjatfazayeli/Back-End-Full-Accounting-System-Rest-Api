<?php

namespace App\Http\Controllers\AdminPanel\Facilities;

use App\Http\Controllers\AdminPanel\FiscalDocument\FiscalDocumentController;
use App\Http\Controllers\Controller;
use App\Http\Requests\FacilityStoreRequest;
use App\Http\Requests\FacilityUpdateRequest;
use App\Http\Resources\FacilityResource;
use App\Http\Resources\FiscalYearResource;
use App\Http\Resources\ReportResource;
use App\Models\Admin;
use App\Models\Cheque;
use App\Models\ChequeSheet;
use App\Models\Facilities;
use App\Models\FiscalDocument;
use App\Models\InstallmentBooklet;
use App\Models\ReportSystem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Morilog\Jalali\Jalalian;
use Webpatser\Uuid\Uuid;

class FacilitiesController extends Controller
{

    public function index(Request $request)
    {
        $facilities = Facilities::query();
        if ($request->has('orderby'))
        {
            $facilities = $facilities->orderBy('id',$request->orderby);
        }
        if ($request->has('title'))
        {
            $facilities = $facilities->where('title','LIKE','%'.$request->title.'%');
        }
        if ($request->has('borrower_id'))
        {
            $facilities = $facilities->where('borrower_id',$request->borrower_id);
        }
        if ($request->has('amount_facility'))
        {
            $facilities = $facilities->where('amount_facility',$request->amount_facility);
        }
        if ($request->has('receiver_date'))
        {
            $facilities = $facilities->where('receiver_date',$request->receiver_date);
        }
        if ($request->has('quantity_installments'))
        {
            $facilities = $facilities->where('quantity_installments',$request->quantity_installments);
        }
        if ($request->has('amount_first_installment'))
        {
            $facilities = $facilities->where('amount_first_installment',$request->amount_first_installment);
        }
        if ($request->has('amount_other_installment'))
        {
            $facilities = $facilities->where('amount_other_installment',$request->amount_other_installment);
        }
        if ($request->has('payment_date'))
        {
            $facilities = $facilities->where('payment_date',$request->payment_date);
        }
        if ($request->has('cheque_id'))
        {
            $facilities = $facilities->where('cheque_id',$request->cheque_id);
        }
        if ($request->has('cheque_sheet_id'))
        {
            $facilities = $facilities->where('cheque_sheet_id',$request->cheque_sheet_id);
        }
        if ($request->has('perpage'))
        {
            $facilities = $facilities->paginate($request->perpage);
            $report = 'no';
        }
        else
        {
            $facilities = $facilities->get();
            $report = $this->reportLog('لیست تسهیلات ایجاد شده');
            $report = new ReportResource($report);

        }
        return response()->json([
            "message" => 'لیست تسهیلات ایجاد شده باموفقیت دریافت شد',
            "report" =>$report,
            "data"=>FacilityResource::collection($facilities)->response()->getData()
        ], 200);

    }
    public function store(FacilityStoreRequest $facilityStoreRequest)
    {
        $jalaliDate =  Jalalian::fromDateTime($facilityStoreRequest->start_installment_date);
        $payment_month = $jalaliDate->getMonth();
        $payment_year = $jalaliDate->getYear();
        $fiscal_document  = new FiscalDocumentController();
        $creator = Admin::find(Auth::user()->id);
        $facility = $creator->facilities()->create($facilityStoreRequest->except(['start_installment_date']));
        $fiscal_document->store_automate($facility);
        for($i = 0 ; $i< $facilityStoreRequest->quantity_installments ; $i++)
        {
            if($i == 0)
            {
                $payment_date = $facilityStoreRequest->start_installment_date;
            }
            else
            {
                $payment_date = Carbon::createFromDate($facilityStoreRequest->start_installment_date)->addMonth($i);
            }
            $payment_month > 12 ? $payment_year = $payment_year + 1 : false;
            $payment_month > 12 ? $payment_month = 1 : false;
            $i == 0 ? $type_installment = 'initial' :  $type_installment = 'other';
            $i == 0 ? $amount_installment =  $facilityStoreRequest->amount_first_installment :  $amount_installment =  $facilityStoreRequest->amount_other_installment;
            $facility->installment_booklet()->create([
                'uuid' => Uuid::generate()->string,
                'nature_installment' => 'receipt',
                'type_installment' => $type_installment,
                'payment_date' => $payment_date,
                'payment_year' => $payment_year,
                'payment_month' => $payment_month,
                'amount_installment' => $amount_installment,
                'fiscal_year' => $facilityStoreRequest->fiscal_year,
                'fiscal_month' => $facilityStoreRequest->fiscal_month,
                'borrower_id' => $facilityStoreRequest->borrower_id,
                'creator_id' => Auth::user()->id
            ]);
            $payment_month =  $payment_month + 1;
        }
        return response()->json([
            "message" => 'تسهیلات باموفقیت ایجاد شد',
            "data"=>new FacilityResource($facility)
        ], 200);
    }
    public function show(Facilities $facilities)
    {
        return response()->json([
            "message" => 'اطلاعات تسهیلات با موفقیت دریافت شد',
            "data"=>new FacilityResource($facilities)
        ], 200);
    }

    public function update(FacilityUpdateRequest $facilityUpdateRequest , Facilities $facilities)
    {
       $installment_booklet =  InstallmentBooklet::where('facility_id',$facilities->id)->get();
       foreach ($installment_booklet as $booklet)
       {
           if ($booklet->status == 'paid')
           {
               return response()->json([
                   "message" => 'به دلیل انجام تراکنش پرداخت قسط برای این دفترچه امکان بروزرسانی وجود ندارد',
               ], 318);
           }
       }
       $installment_booklet->map->delete();
       $facilities->update($facilityUpdateRequest->all());
        $payment_year = $facilityUpdateRequest->fiscal_year;
        $payment_month = $facilityUpdateRequest->fiscal_month;
        for($i = 0 ; $i< $facilityUpdateRequest->quantity_installments ; $i++)
        {
            $payment_month > 12 ? $payment_year = $payment_year + 1 : false;
            $payment_month > 12 ? $payment_month = 1 : false;
            $i == 0 ? $type_installment = 'initial' :  $type_installment = 'other';
            $i == 0 ? $amount_installment =  $facilityUpdateRequest->amount_first_installment :  $amount_installment =  $facilityUpdateRequest->amount_other_installment;
            $facilities->installment_booklet()->create([
                'uuid' => Uuid::generate()->string,
                'nature_installment' => 'receipt',
                'type_installment' => $type_installment,
                'payment_year' => $payment_year,
                'payment_month' => $payment_month,
                'amount_installment' => $amount_installment,
                'fiscal_year' => $facilityUpdateRequest->fiscal_year,
                'fiscal_month' => $facilityUpdateRequest->fiscal_month,
                'borrower_id' => $facilityUpdateRequest->borrower_id,
                'creator_id' => Auth::user()->id
            ]);
            $payment_month =  $payment_month + 1;
        }
        return response()->json([
            "message" => 'تسهیلات باموفقیت بروزرسانی شد',
            "data"=>new FacilityResource($facilities)
        ], 200);
    }

    public function delete(Request $request)
    {
        $items = explode(',',$request->items);
        foreach ($items as $item)
        {
            $facility = Facilities::find($item);
            if ($facility)
            {
                $installment_booklet = $facility->installment_booklet()->where('status','!=','unpaid')->first();
                if ($installment_booklet)
                {
                    return response()->json([
                        "message" => 'به دلیل انجام تراکنش پرداخت قسط برای این تسهیلات امکان حذف وجود ندارد',
                    ], 200);
                }
                $facility ? $facility->delete() : false;
                $installment_booklets =  InstallmentBooklet::where('facility_id',$facility->id)->get();
                $installment_booklets->map->delete();

            }
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
