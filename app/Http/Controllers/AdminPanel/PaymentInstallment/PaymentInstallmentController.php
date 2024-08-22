<?php

namespace App\Http\Controllers\AdminPanel\PaymentInstallment;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentInstallmentStoreRequest;
use App\Http\Requests\PaymentInstallmentUpdateRequest;
use App\Http\Resources\AdminInfoResource;
use App\Http\Resources\PaymentInstallmentDocumentResource;
use App\Http\Resources\PaymentInstallmentResource;
use App\Http\Resources\ReportResource;
use App\Models\BankList;
use App\Models\Facilities;
use App\Models\InstallmentBooklet;
use App\Models\PaymentInstallment;
use App\Models\ReportSystem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Webpatser\Uuid\Uuid;

class PaymentInstallmentController extends Controller
{

    public function index(Request $request, Facilities $facilities)
    {
        $payment_installments = $facilities->payment_installments();

        if ($request->has('perpage'))
        {
            $payment_installments = $payment_installments->paginate($request->perpage);
            $report = 'no';
        }
        else
        {
            $payment_installments = $payment_installments->get();
            $report = $this->reportLog('لیست تراکنش های تسهیلات');
            $report = new ReportResource($report);

        }
        return response()->json([
            "message" => 'لیست تراکنش تسهیلات مورد نظر با موفقیت دریافت شد',
            "report" =>$report,
            "data"=>PaymentInstallmentResource::collection($payment_installments)->response()->getData()
        ], 200);
    }
    public function store(PaymentInstallmentStoreRequest $paymentInstallmentStoreRequest , Facilities $facilities)
    {
       $payment_installment =  $facilities->payment_installments()->create($paymentInstallmentStoreRequest->all());
       if ($paymentInstallmentStoreRequest->hasFile('file'))
       {
           $avatarPath = Storage::putFile('/installment' , $paymentInstallmentStoreRequest->file);
           $payment_installment->update(['file' => $avatarPath]);
       }
        return response()->json([
            "message" => 'پرداخت قسط تسهیلات باموفقیت ثبت شد',
            "data"=> new PaymentInstallmentResource($payment_installment)
        ], 200);
    }

    public function banklist()
    {
        $banklist = BankList::all();
        return response()->json([
            "message" => 'لیست بانک ها باموفقیت دریافت شد',
            "data"=> $banklist
        ], 200);
    }

    public function update(PaymentInstallmentUpdateRequest $paymentInstallmentUpdateRequest , PaymentInstallment $paymentInstallment)
    {
        if ($paymentInstallmentUpdateRequest->hasFile('file'))
        {
            Storage::delete($paymentInstallment->file);
            $avatarPath = Storage::putFile('/installment' , $paymentInstallmentUpdateRequest->file);
            $paymentInstallment->update(['file' => $avatarPath]);
        }
        $paymentInstallment->update($paymentInstallmentUpdateRequest->except('file'));
        return response()->json([
            "message" => 'اطلاعات پرداخت با موفقیت بروزرسانی شد',
            "data"=> new PaymentInstallmentResource($paymentInstallment)
        ], 200);
    }

    public function delete(Request $request)
    {
        $items = explode(',',$request->items);
        foreach ($items as $item)
        {
            $payment_installment= PaymentInstallment::find($item);
            if ($payment_installment)
            {
                if ($payment_installment->status == 'accepted')
                {
                    $payment_installment->installment_booklet()->update(['status' => 'unpaid']);
                }
                $payment_installment ? $payment_installment->delete() : false;
            }
        }
        return response()->json([
            "message" => 'حذف با موفقیت انجام شد',
        ], 200);
    }



    public function show(PaymentInstallment $paymentInstallment)
    {
        return response()->json([
            "message" => 'اطلاعات پرداخت با موفقیت دریافت شد',
            "data"=> new PaymentInstallmentResource($paymentInstallment)
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
