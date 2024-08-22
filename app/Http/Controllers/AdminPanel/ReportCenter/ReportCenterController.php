<?php

namespace App\Http\Controllers\AdminPanel\ReportCenter;

use App\Http\Controllers\Controller;
use App\Http\Resources\FacilityResource;
use App\Http\Resources\FiscalDocumentNormalResource;
use App\Http\Resources\FiscalDocumentResource;
use App\Http\Resources\InstallmentBookletResource;
use App\Http\Resources\MembershipResource;
use App\Http\Resources\MembershipRightReportResource;
use App\Http\Resources\PaymentInstallmentDocumentResource;
use App\Http\Resources\ReportResource;
use App\Http\Resources\TestResource;
use App\Models\Account;
use App\Models\Facilities;
use App\Models\FiscalDocument;
use App\Models\FiscalDocumentItem;
use App\Models\FiscalTransaction;
use App\Models\PaymentInstallment;
use App\Models\ReportSystem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;

class ReportCenterController extends Controller
{
    public function paymentInstallment(Request $request)
    {
        $payment_installment = PaymentInstallment::query();
        if ($request->has('orderby'))
        {
            $payment_installment = $payment_installment->orderBy('id',$request->orderby);
        }
        if ($request->has('subscriber_id'))
        {
            $payment_installment = $payment_installment->where('payer_id',$request->subscriber_id);
        }
        if ($request->has('facility_id'))
        {
            $payment_installment = $payment_installment->where('facility_id',$request->facility_id);
        }
        if ($request->has('start_date') and $request->has('end_date'))
        {
            $payment_installment = $payment_installment->whereBetween('payment_date', [$request->start_date, $request->end_date]);
        }
        if ($request->has('perpage'))
        {
            $payment_installment = $payment_installment->paginate($request->perpage);
            $report = 'no';
        }
        else
        {
            $payment_installment = $payment_installment->get();
            $report = $this->reportLog('سند گزارش اقساط پرداختی');
            $report = new ReportResource($report);

        }
        return response()->json([
            "message" => 'سند گزارش اقساط پرداختی با موفقیت دریافت شد',
            "report" =>$report,
            "data"=>PaymentInstallmentDocumentResource::collection($payment_installment)->response()->getData()
        ], 200);
    }

    public function wageFacility(Request $request)
    {
        $facility = Facilities::query();
        if ($request->has('orderby'))
        {
            $facility = $facility->orderBy('id',$request->orderby);
        }
        if ($request->has('subscriber_id'))
        {
            $facility = $facility->where('borrower_id',$request->subscriber_id);
        }
        if ($request->has('facility_id'))
        {
            $facility = $facility->where('id',$request->facility_id);
        }
        if ($request->has('start_date') and $request->has('end_date'))
        {
            $facility = $facility->whereBetween('payment_date', [$request->start_date, $request->end_date]);
        }
        if ($request->has('perpage'))
        {
            $facility = $facility->paginate($request->perpage);
            $report = 'no';
        }
        else
        {
            $facility = $facility->get();
            $report = $this->reportLog('سند کارمزد دریافتی تسهسلات پرداختی');
            $report = new ReportResource($report);

        }
        return response()->json([
            "message" => 'سند کارمزد دریافتی تسهسلات پرداختی با موفقیت دریافت شد',
            "report" =>$report,
            "data"=>FacilityResource::collection($facility)->response()->getData()
        ], 200);
    }

    public function participantRight(Request $request)
    {
        $fiscal_document = FiscalDocument::where('type_document','installments');
        if ($request->has('orderby'))
        {
            $fiscal_document = $fiscal_document->orderBy('id',$request->orderby);
        }
        if ($request->has('start_date') and $request->has('end_date'))
        {
            $fiscal_document = $fiscal_document->whereBetween('document_date', [$request->start_date, $request->end_date]);
        }
        if ($request->has('perpage'))
        {
            $fiscal_document = $fiscal_document->paginate($request->perpage);
            $report = 'no';
        }
        else
        {
            $fiscal_document = $fiscal_document->get();
            $report = $this->reportLog('گزارش حق مشارکت کارکنان');
            $report = new ReportResource($report);
        }
        return response()->json([
            "message" => 'سند حق مشارکت کارکنان با موفقیت دریافت شد',
            "report" =>$report,
            "data"=>MembershipRightReportResource::collection($fiscal_document)->response()->getData()
        ], 200);
    }

    public function membershipRight(Request $request)
    {
       $subscriber_fiscal_transaction =  FiscalTransaction::where('sub_scriber_id' , $request->subscriber_id);
        if ($request->has('orderby'))
        {
            $subscriber_fiscal_transaction = $subscriber_fiscal_transaction->orderBy('id',$request->orderby);
        }
        if ($request->has('start_date') and $request->has('end_date'))
        {
            $subscriber_fiscal_transaction = $subscriber_fiscal_transaction->whereBetween('payment_date', [$request->start_date, $request->end_date]);
        }
        if ($request->has('perpage'))
        {
            $subscriber_fiscal_transaction = $subscriber_fiscal_transaction->paginate($request->perpage);
            $report = 'no';
        }
        else
        {
            $subscriber_fiscal_transaction = $subscriber_fiscal_transaction->get();
            $report = $this->reportLog('گزارش حق اشتراک کارکنان');
            $report = new ReportResource($report);

        }
        return response()->json([
            "message" => 'سند حق اشتراک و کسرانگیزشی کارکنان با موفقیت دریافت شد',
            "report" =>$report,
            "data"=>MembershipResource::collection($subscriber_fiscal_transaction)->response()->getData()
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

    public function normalReport(Request $request)
    {
        $subscriber_fiscal_transaction =  FiscalTransaction::where('sub_scriber_id' , '8');
        if ($request->has('orderby'))
        {
            $subscriber_fiscal_transaction = $subscriber_fiscal_transaction->orderBy('id',$request->orderby);
        }
        if ($request->has('start_date') and $request->has('end_date'))
        {
            $subscriber_fiscal_transaction = $subscriber_fiscal_transaction->whereBetween('payment_date', [$request->start_date, $request->end_date]);
        }
        if ($request->has('perpage'))
        {
            $subscriber_fiscal_transaction = $subscriber_fiscal_transaction->paginate($request->perpage);
            $report = 'no';
        }
        else
        {
            $subscriber_fiscal_transaction = $subscriber_fiscal_transaction->get();
            $report = $this->reportLog('گزارش  ساز عادی');
            $report = new ReportResource($report);

        }
        return response()->json([
            "message" => 'گزارش عادی با موفقیت دریافت شد',
            "report" =>$report,
            "data"=>TestResource::collection($subscriber_fiscal_transaction)->response()->getData()
        ], 200);
        //dd($request->all());
        //$account = Account::find($request->account_ids);
        //$x = FiscalDocumentItem::where('account_id' , $account->id)->get();
        /*        $data = [];
                $accounts = explode(',',$request->account_ids);
                foreach ($accounts as $account)
                {
                    $account = Account::find($account);

                   //$fiscal_document_item =  FiscalDocumentItem::where('account_id' , $account)->get();
                    dd($account->fiscal_document_item);
                    $fiscal_document_item = $account->fiscal_document_item;
                    $data = $fiscal_document_item;

                }
                return response()->json([
                    "message" => 'گزارش سند عادی باموفقیت دریافت شد',
                    "data"=> FiscalDocumentNormalResource::collection($data)
                ], 200);*/
    }

}
