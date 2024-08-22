<?php

namespace App\Http\Controllers\AdminPanel\FiscalTransaction;

use App\Http\Controllers\Controller;
use App\Http\Requests\FiscalTransactionStoreRequest;
use App\Http\Requests\FiscalTransactionUpdateRequest;
use App\Http\Requests\InitialFiscalTransactionStoreRequest;
use App\Http\Resources\ChequeInfoResource;
use App\Http\Resources\FiscalTransactionPaymentListResource;
use App\Http\Resources\FiscalTransactionSubScriberPaymentResource;
use App\Http\Resources\FiscalTransactionSubScriberStatusResource;
use App\Http\Resources\ReceiptInfoResource;
use App\Http\Resources\ReportResource;
use App\Models\FiscalDocument;
use App\Models\FiscalTransaction;
use App\Models\FiscalYearsItem;
use App\Models\InstallmentBooklet;
use App\Models\ReportSystem;
use App\Models\SubScriber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Webpatser\Uuid\Uuid;

class FiscalTransactionController extends Controller
{
    public function statusGet(Request $request , SubScriber $subScriber)
    {
        return response()->json([
            "message" => 'اطلاعات مبالغ قابل پرداخت مشترک با موفقیت دریافت گردید',
            "data"=> new FiscalTransactionSubScriberStatusResource($subScriber)
        ], 200);
    }
    public function store(FiscalTransactionStoreRequest $fiscalTransactionStoreRequest , SubScriber $subScriber)
    {
        $monthly_subscription = 0;
        $participationـrights = 0;
        $motivational = 0;
        $fiscal_year_item = FiscalYearsItem::where('status' , 'active')->first();
        $subScriber->monthly_subscription == 'active' ? $monthly_subscription = $fiscal_year_item->amount_membershipـright_month * $subScriber->status_portion : $monthly_subscription = 0;
        $subScriber->participationـrights == 'active' ? $participationـrights = $fiscal_year_item->amount_participate_right : $participationـrights = 0;
        $subScriber->motivational == 'active' ? $motivational = $fiscal_year_item->amount_motivational : $motivational = 0;
        $installment =   $subScriber->installment_booklet()->where('payment_year' , $fiscalTransactionStoreRequest->fiscal_year)->where('payment_month' , $fiscalTransactionStoreRequest->fiscal_month)->first();
       if ($installment)
       {
           $total_payable = $monthly_subscription + $participationـrights + $motivational + $installment->amount_installment;

       }
       else
       {
           $total_payable = $monthly_subscription + $participationـrights + $motivational;
       }

        if ($total_payable == $fiscalTransactionStoreRequest->payment_amount)
        {
            if ($fiscalTransactionStoreRequest->hasFile('file')) {
                $filePath = Storage::putFile('/installment', $fiscalTransactionStoreRequest->file);
                //$filePath = env('APP_STORAGE').'/'.$filePath;
            }
            if ($monthly_subscription > 0)
            {
                $fiscalTransactionStoreRequest['type'] = 'membershipـright';
                $fiscalTransactionStoreRequest['payment_amount'] = $monthly_subscription;
                $fiscal_membershipـright =  $subScriber->fiscal_transaction()->create($fiscalTransactionStoreRequest->all());
                $fiscal_membershipـright->update(['file' => $filePath]);
            }
            if ($motivational > 0)
            {
                $fiscalTransactionStoreRequest['type'] = 'motivational';
                $fiscalTransactionStoreRequest['payment_amount'] = $motivational;
                $fiscal_motivational = $subScriber->fiscal_transaction()->create($fiscalTransactionStoreRequest->all());
                $fiscal_motivational->update(['file' => $filePath]);
            }
            if ($participationـrights > 0)
            {
                $fiscalTransactionStoreRequest['type'] = 'participate_right';
                $fiscalTransactionStoreRequest['payment_amount'] = $participationـrights;
                $fiscal_participate_right = $subScriber->fiscal_transaction()->create($fiscalTransactionStoreRequest->all());
                $fiscal_participate_right->update(['file' => $filePath]);
            }
            if ($installment)
            {
                $fiscalTransactionStoreRequest['installment_booklet_id'] = $installment->id;
                $fiscalTransactionStoreRequest['facility_id'] = $installment->facility_id;
                $fiscalTransactionStoreRequest['payer_id'] = $subScriber->id;
                $fiscalTransactionStoreRequest['payment_amount'] = $installment->amount_installment;
                $fiscalTransactionStoreRequest['status'] = 'paid';
                $fiscal_installment = $installment->payment_installment()->create($fiscalTransactionStoreRequest->all());
                $fiscal_installment->update(['file' => $filePath]);
            }
            return response()->json([
                "message" => 'ثبت پرداخت با موفقیت انجام شد',
                "data"=> new FiscalTransactionSubScriberPaymentResource($subScriber)
            ], 200);
        }
        return response()->json([
            "message" => 'ثبت پرداخت با موفقیت انجام شد',
            //"data"=> new FiscalTransactionSubScriberPaymentResource($subScriber)
        ], 200);

    }

    public function initialStore(InitialFiscalTransactionStoreRequest $initialFiscalTransactionStoreRequest , SubScriber $subScriber)
    {
        $fiscal_transaction = $subScriber->fiscal_transaction()->create($initialFiscalTransactionStoreRequest->all());
        $subScriber->update(['membershipـfee' =>'paid']);
        if ($initialFiscalTransactionStoreRequest->hasFile('file')) {
            $filePath = Storage::putFile('/installment', $initialFiscalTransactionStoreRequest->file);
            $fiscal_transaction->update(['file' => $filePath]);
        }
        return response()->json([
            "message" => 'حق عضویت اولیه با موفقیت پرداخت شد',
            "data"=>new FiscalTransactionPaymentListResource($fiscal_transaction)
        ], 200);
    }
    public function index(Request $request)
    {
        $fiscaltransaction = FiscalTransaction::where('sub_scriber_id' , $request->sub_scriber_id);
        if ($request->has('orderby'))
        {
            $fiscaltransaction = $fiscaltransaction->orderBy('id',$request->orderby);
        }
        if ($request->has('type'))
        {
            $fiscaltransaction = $fiscaltransaction->where('type',$request->type);
        }
        if ($request->has('payment_type'))
        {
            $fiscaltransaction = $fiscaltransaction->where('payment_type',$request->payment_type);
        }
        if ($request->has('payment_amount'))
        {
            $fiscaltransaction = $fiscaltransaction->where('payment_amount',$request->payment_amount);
        }
        if ($request->has('payment_tracking_code'))
        {

            $fiscaltransaction = $fiscaltransaction->where('payment_tracking_code',$request->payment_tracking_code);
       }
        if ($request->has('bank_list_id'))
        {
            $fiscaltransaction = $fiscaltransaction->where('bank_list_id',$request->bank_list_id);
        }
        if ($request->has('checker_id'))
        {
            $fiscaltransaction = $fiscaltransaction->where('checker_id',$request->checker_id);
        }
        if ($request->has('status'))
        {
            $fiscaltransaction = $fiscaltransaction->where('status',$request->status);
        }
        if ($request->has('perpage'))
        {
            $fiscaltransaction = $fiscaltransaction->paginate($request->perpage);
            $report = 'no';
        }
        else
        {
            $fiscaltransaction = $fiscaltransaction->get();
            $report = $this->reportLog('گزارش تراکنش مالی');
            $report = new ReportResource($report);
        }
        return response()->json([
            "message" => 'لیست تراگنش مالی باموفقیت دریافت شد',
            "report" =>$report,
            "data"=>FiscalTransactionPaymentListResource::collection($fiscaltransaction)->response()->getData()
        ], 200);
    }
    public function show(FiscalTransaction $fiscalTransaction)
    {
        return response()->json([
            "message" => 'تراگنش مالی باموفقیت دریافت شد',
            "data"=>new FiscalTransactionPaymentListResource($fiscalTransaction)
        ], 200);
    }
    public function update(FiscalTransactionUpdateRequest $fiscalTransactionUpdateRequest , FiscalTransaction $fiscalTransaction)
    {
        $fiscalTransaction->update($fiscalTransactionUpdateRequest->all());
        if ($fiscalTransactionUpdateRequest->hasFile('file')) {
            $filePath = Storage::putFile('/installment', $fiscalTransactionUpdateRequest->file);
            $fiscalTransaction->update(['file'=>$filePath]);
        }
        return response()->json([
            "message" => 'تراگنش مالی باموفقیت بروزرسانی شد',
            "data"=>new FiscalTransactionPaymentListResource($fiscalTransaction)
        ], 200);
    }
    public function delete(Request $request)
    {
        $items = explode(',',$request->items);
        foreach ($items as $item)
        {
        $fiscal_transaction = FiscalTransaction::find($item);
        if ($fiscal_transaction)
        {
            if ($fiscal_transaction->status != 'pending')
            {
                return response()->json([
                    "message" => 'به دلیل تغییر وضعیت تراکنش امکان حذف وجود ندارد',
                ], 200);
            }
            else
            {
                $fiscal_transaction ? $fiscal_transaction->delete() : false;

            }
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
