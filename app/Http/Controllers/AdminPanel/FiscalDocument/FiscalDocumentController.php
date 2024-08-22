<?php

namespace App\Http\Controllers\AdminPanel\FiscalDocument;

use App\Enums\FiscalDocumentNatureEnum;
use App\Enums\FiscalDocumentStatusEnum;
use App\Enums\FiscalDocumentTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\FiscalDocumentStoreRequest;
use App\Http\Requests\FiscalDocumentUpdateRequest;
use App\Http\Requests\FiscalYearItemStoreRequest;
use App\Http\Requests\InstallmentDocumentRequest;
use App\Http\Requests\MemberShipRightDocumentRequest;
use App\Http\Resources\FiscalDocumentResource;
use App\Http\Resources\InstallmentBookletResource;
use App\Http\Resources\ReceiptInfoResource;
use App\Http\Resources\ReportResource;
use App\Models\AccountSubScriber;
use App\Models\FiscalDocument;
use App\Models\FiscalDocumentItem;
use App\Models\FiscalYear;
use App\Models\FiscalYearsItem;
use App\Models\InstallmentBooklet;
use App\Models\PaymentInstallment;
use App\Models\Receipt;
use App\Models\ReportSystem;
use App\Models\SubScriber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Morilog\Jalali\Jalalian;
use phpDocumentor\Reflection\Types\Null_;
use Webpatser\Uuid\Uuid;

class FiscalDocumentController extends Controller
{

    public function check_Membership_right_Document(MemberShipRightDocumentRequest $memberShipRightDocumentRequest)
    {
        $sumation = 0;
        $fiscal_year_item = FiscalYearsItem::where('status' , 'active')->first();
        $sum_motivation_fee_subscribers = SubScriber::where('motivational' , 'active')->get();
        $sum_membershipـright_month_subscribers = SubScriber::where('monthly_subscription' , 'active')->get();
        $subscriber_active_participationـrights = SubScriber::where('participationـrights' , 'active')->get();
        $subscribers = SubScriber::all();
        $participationـright = count($subscriber_active_participationـrights) * $fiscal_year_item->amount_participate_right;
        $installments =  InstallmentBooklet::where('payment_year' , $memberShipRightDocumentRequest->year)->where('payment_month' , $memberShipRightDocumentRequest->month)->get();
        $unpaid_installments =  InstallmentBooklet::where('payment_year' , $memberShipRightDocumentRequest->year)->where('payment_month' , $memberShipRightDocumentRequest->month)->where('status' , 'unpaid')->paginate();
        $paid_installments =  InstallmentBooklet::where('payment_year' , $memberShipRightDocumentRequest->year)->where('payment_month' , $memberShipRightDocumentRequest->month)->where('status' , 'paid')->get();
        if (count($paid_installments) < count($installments))
        {
            return response()->json([
                "message" => 'متاسفانه بدلیل عدم پرداخت حق اشتراک مشترکین امکان صدور سند حق اشتراک و انگزیشی موردنظر مقدور نمی باشد',
                "error" => 'yes',
                "data"=> InstallmentBookletResource::collection($unpaid_installments)->response()->getData()
            ], 200);
        }
        else
        {
            $fiscal_document =   $this->build_Membership_right_Document($subscribers,$memberShipRightDocumentRequest);
            return response()->json([
                "message" => 'سند اقساط تسهیلات با موفقیت صادر شد',
                "data"=> new FiscalDocumentResource($fiscal_document)
            ], 200);
        }

    }

    public function build_Membership_right_Document($subscribers,$memberShipRightDocument)
    {
        $sumـstaffـfund = 0;
        $sum_membership = 0;
        $fiscal_year = FiscalYear::where('year',$memberShipRightDocument->year)->first();
        $fiscal_year_items = FiscalYearsItem::where('status','active')->first();
        $month_name = Jalalian::forge($memberShipRightDocument->month)->format('%B');
        $fiscal_document = FiscalDocument::create([
            'nature_document' => FiscalDocumentNatureEnum::Automate,
            'type_document' => FiscalDocumentTypeEnum::Installments,
            'title' => 'سند حق اشتراک و کسرانگیزشی'.' '.$month_name.'ماه سال'. $memberShipRightDocument->year,
            'description' => 'این سند بصورت خودکار ایجاد شده است',
            'document_date' => $memberShipRightDocument->document_date,
            'serial_code' => mt_rand('11111','99999'),
            'payment_date' => null,
            'fiscal_year' => $fiscal_year->year,
            'fiscal_month' => $memberShipRightDocument->month,
            'status' => FiscalDocumentStatusEnum::Definitive,
        ]);
        foreach ($subscribers as $subscriber)
        {
            $sumation = 0;
            $account = AccountSubScriber::where('type' , 'membership')->where('sub_scriber_id' , $subscriber->id)->first();
            if ($subscriber->monthly_subscription == 'active')
            {
                $sumation += $fiscal_year_items->amount_membershipـright_month;
            }
            if ($subscriber->motivational == 'active')
            {
                $sumation += $fiscal_year_items->amount_motivational;
            }
            if ($subscriber->participationـrights == 'active')
            {
                $sum_membership += $fiscal_year_items->amount_participate_right;
            }
            //TODO باید بعد از تکیل اطلاعات حساب در دیتابیس  مثدار account_id تغییر کند
            $sumـstaffـfund += $sumation;
            $fiscal_document->fiscal_document_item()->create([
                'description' => 'حق اشتراک'.' '.$subscriber->firstname .' '.$subscriber->lastname .' '.$month_name.' '.'ماه'.' '.$fiscal_year->year,
                'deptor'=> '0',
                'creditor' => $sumation,
                'status'=> 'normal',
                'fiscal_year' => $fiscal_year->year,
                'fiscal_month' => $memberShipRightDocument->month,
                //'account_id' => $account->account_id,
                'account_id' => '48',
                'creator_id' => Auth::user()->id
            ]);
        }
        $fiscal_document->fiscal_document_item()->create([
            'description' => 'حق مشارکت صندوق کارکنان'.' '.$month_name.'ماه سال'. $memberShipRightDocument->year,
            'deptor'=> '0',
            'creditor' => $sum_membership,
            'status'=> 'normal',
            'fiscal_year' => $fiscal_year->year,
            'fiscal_month' => $memberShipRightDocument->month,
            'account_id' => '56',
            'creator_id' => Auth::user()->id
        ]);
        $fiscal_document->fiscal_document_item()->create([
            'description' => 'بانک صندوق کارکنان',
            'deptor'=> '0',
            'creditor' => $sumـstaffـfund,
            'status'=> 'normal',
            'fiscal_year' => $fiscal_year->year,
            'fiscal_month' => $memberShipRightDocument->month,
            'account_id' => '47',
            'creator_id' => Auth::user()->id
        ]);
        $fiscal_document->fiscal_document_item()->create([
            'description' => 'بانک صندوق مشارکت',
            'deptor'=> $sum_membership,
            'creditor' => '0',
            'status'=> 'normal',
            'fiscal_year' => $fiscal_year->year,
            'fiscal_month' => $memberShipRightDocument->month,
            'account_id' => '58',
            'creator_id' => Auth::user()->id
        ]);

        return $fiscal_document;

    }

    public function check_Installment_Document(InstallmentDocumentRequest $installmentDocumentRequest)
    {
           $installments =  InstallmentBooklet::where('payment_year' , $installmentDocumentRequest->year)->where('payment_month' , $installmentDocumentRequest->month)->get();
           $unpaid_installments =  InstallmentBooklet::where('payment_year' , $installmentDocumentRequest->year)->where('payment_month' , $installmentDocumentRequest->month)->where('status' , 'unpaid')->paginate();
           $paid_installments =  InstallmentBooklet::where('payment_year' , $installmentDocumentRequest->year)->where('payment_month' , $installmentDocumentRequest->month)->where('status' , 'paid')->get();
           if (count($paid_installments) < count($installments))
           {
               return response()->json([
                   "message" => 'متاسفانه بدلیل عدم پرداخت اقساط مشترکین امکان صدور سند اقساط موردنظر مقدور نمی باشد',
                   "data"=> InstallmentBookletResource::collection($unpaid_installments)->response()->getData()
               ], 318);
           }
           //TODO It Has equal Sum paid_installment and Sum installments . The Remaining Is membership Right
            if (count($paid_installments) == count($installments))
            {
                $fiscal_document = $this->build_Installment_Document($paid_installments,$installmentDocumentRequest);
                return response()->json([
                    "message" => 'سند اقساط تسهیلات با موفقیت صادر شد',
                    "data"=> new FiscalDocumentResource($fiscal_document)
                ], 200);
            }

    }

    public function build_Installment_Document($paind_installments,$installment_document_info)
    {
        $sum_paid_installment = $paind_installments->sum('amount_installment');
        $fiscal_year = FiscalYear::where('year',$installment_document_info->year)->first();
        $month_name = Jalalian::forge($installment_document_info->month)->format('%B');
        $fiscal_document = FiscalDocument::create([
            'nature_document' => FiscalDocumentNatureEnum::Automate,
            'type_document' => FiscalDocumentTypeEnum::Installments,
            'title' => 'سند اقساط صندوق کارکنان در'.' '.$month_name.'ماه سال'. $installment_document_info->year,
            'description' => 'این سند بصورت خودکار ایجاد شده است',
            'document_date' => $installment_document_info->document_date,
            'serial_code' => mt_rand('11111','99999'),
            'payment_date' => null,
            'fiscal_year' => $fiscal_year->year,
            'fiscal_month' => $installment_document_info->month,
            'status' => FiscalDocumentStatusEnum::Definitive,
        ]);
        $fiscal_document->fiscal_document_item()->create([
            'description' => 'بانک صندوق کارکنان',
            'deptor'=> $sum_paid_installment,
            'creditor' => '0',
            'status'=> 'definitive',
            'fiscal_year' => $fiscal_year->year,
            'fiscal_month' => $installment_document_info->month,
            'account_id' => '47',
            'creator_id' => Auth::user()->id
        ]);

        foreach ($paind_installments as $key=>$paind_installment)
        {

            $payment_installment = PaymentInstallment::where('installment_booklet_id' , $paind_installment->id)->first();
            $subscriber = $payment_installment->subscriber;
            $account_facility = $subscriber->account_subscriber()->where('type' , 'facility')->first();
            $fiscal_document->fiscal_document_item()->create([
                'description' => 'قسط وام'.' '.$payment_installment->subscriber->firstname .' '.$payment_installment->subscriber->lastname,
                'deptor'=> '0',
                'creditor' => $payment_installment->payment_amount,
                'status'=> 'definitive',
                'fiscal_year' => $fiscal_year->year,
                'fiscal_month' => $installment_document_info->month,
                'account_id' => $account_facility->account_id,
                'creator_id' => Auth::user()->id
            ]);
        }
        return $fiscal_document;

    }
    public function check()
    {
        $currentDateTime = Carbon::now('Asia/Tehran');
        $jalaliDateTime = Jalalian::fromCarbon($currentDateTime);
        if ($jalaliDateTime->getDay() == '5')
        {
            dd('روز پنجم هستیم');
        }
        else
        {
            dd($jalaliDateTime->getDay());
        }
    }

    public function store(FiscalDocumentStoreRequest $fiscalDocumentStoreRequest)
    {
       $fiscal_document =  FiscalDocument::create($fiscalDocumentStoreRequest['fiscal_document']);
       foreach ($fiscalDocumentStoreRequest['items'] as $item)
       {
           $fiscal_document->fiscal_document_item()->create($item);
       }
        return response()->json([
            "message" => 'سند با موفقیت ایجاد شد',
            "data"=> new FiscalDocumentResource($fiscal_document)
        ], 200);

    }

    public function update(FiscalDocumentUpdateRequest $fiscalDocumentUpdateRequest , FiscalDocument $fiscalDocument)
    {
        foreach ($fiscalDocument->fiscal_document_item()->get() as $item)
        {
            $item->delete();
        }
        $fiscalDocument->update($fiscalDocumentUpdateRequest['fiscal_document']);
        foreach ($fiscalDocumentUpdateRequest['items'] as $item)
        {
            $fiscalDocument->fiscal_document_item()->create($item);
        }
        return response()->json([
            "message" => 'سند با موفقیت بروزرسانی شد',
            "data"=> new FiscalDocumentResource($fiscalDocument)
        ], 200);
    }

    public function store_automate($data)
    {
        $borrower = SubScriber::find($data['borrower_id']);
        $account_facility = $borrower->account_subscriber()->where('type' , 'facility')->first();
        $account_facility = $account_facility->account()->first();
        $fiscal_year = FiscalYear::where('year',$data['fiscal_year'])->first();
        //$fiscal_year_item = $fiscal_year->fiscal_year_item()->where('status','active')->first();
        $fiscal_year_item = FiscalYearsItem::where('status','active')->first();
        $amount_wage = ($data['amount_facility'] * $fiscal_year_item->fee_percentage)/100;
        $net_payable = $data['amount_facility'] - $amount_wage;
        $fiscal_document = FiscalDocument::create([
            'nature_document' => FiscalDocumentNatureEnum::Automate,
            'type_document' => FiscalDocumentTypeEnum::Facility,
            'title' => 'سند پرداخت تسهیلات صندوق کارکنان سازمان تامین اجتماعی شعبه نیشابور به'.' '.$borrower->firstname.' '. $borrower->lastname,
            'description' => 'این سند به صورت خودکار توسط نرم افزار جهت تسهیلات به شماره '.' '.$data['code'].'ایجاد گردیده است .',
            'document_date' => $data['payment_date'],
            'serial_code' => mt_rand('11111','99999'),
            'payment_date' => $data['payment_date'],
            'fiscal_year' => $data['fiscal_year'],
            'fiscal_month' => $data['fiscal_month'],
            'status' => FiscalDocumentStatusEnum::Definitive,
            'cheque_id' => $data['cheque_id'],
            'cheque_sheet_id' => $data['cheque_sheet_id']
        ]);
        $fiscal_document->fiscal_document_item()->create([
            'description' => 'تسهیلات پرداختی به'.' ',$borrower->firstname.' '.$borrower->lastname,
            'deptor'=> $data['amount_facility'],
            'creditor' => '0',
            'status'=> 'normal',
            'fiscal_year' => $data['fiscal_year'],
            'fiscal_month' => $data['fiscal_month'],
            'account_id' => $account_facility->id,
            'creator_id' => $data['creator_id']
        ]);
        $fiscal_document->fiscal_document_item()->create([
            'description' => $fiscal_year_item->fee_percentage.'درصد کارمزد وام به'.' ',$borrower->firstname.' '.$borrower->lastname,
            'deptor'=> '0',
            'creditor' => $amount_wage,
            'status'=> 'normal',
            'fiscal_year' => $data['fiscal_year'],
            'fiscal_month' => $data['fiscal_month'],
            'account_id' => '46',
            'creator_id' => $data['creator_id']
        ]);
        $fiscal_document->fiscal_document_item()->create([
            'description' => 'پرداختی وام به'.' ',$borrower->firstname.' '.$borrower->lastname,
            'deptor'=> '0',
            'creditor' => $net_payable,
            'status'=> 'normal',
            'fiscal_year' => $data['fiscal_year'],
            'fiscal_month' => $data['fiscal_month'],
            'account_id' => '47',
            'creator_id' => $data['creator_id']
        ]);
    }


    public function index(Request $request)
    {
        $fiscal_document = FiscalDocument::where('nature_document' , $request->nature_document);
        if ($request->has('orderby'))
        {
            $fiscal_document = $fiscal_document->orderBy('id',$request->orderby);
        }
        if ($request->has('serial_code'))
        {
            $fiscal_document = $fiscal_document->where('serial_code',$request->serial_code);
        }
        if ($request->has('nature_document'))
        {
            $fiscal_document = $fiscal_document->where('nature_document',$request->nature_document);
        }
        if ($request->has('type_document'))
        {
            $fiscal_document = $fiscal_document->where('type_document',$request->type_document);
        }
        if ($request->has('title'))
        {
            $fiscal_document = $fiscal_document->where('title','LIKE','%'.$request->title.'%');
        }
        if ($request->has('document_date'))
        {
            $fiscal_document = $fiscal_document->where('document_date',$request->document_date);
        }
        if ($request->has('payment_date'))
        {
            $fiscal_document = $fiscal_document->where('payment_date',$request->payment_date);
        }
        if ($request->has('fiscal_year'))
        {
            $fiscal_document = $fiscal_document->where('fiscal_year',$request->fiscal_year);
        }
        if ($request->has('fiscal_month'))
        {
            $fiscal_document = $fiscal_document->where('fiscal_month',$request->fiscal_month);
        }
        if ($request->has('creator_id'))
        {
            $fiscal_document = $fiscal_document->where('creator_id',$request->creator_id);
        }
        if ($request->has('status'))
        {
            $fiscal_document = $fiscal_document->where('status',$request->status);
        }

        if ($request->has('perpage'))
        {
            $fiscal_document = $fiscal_document->paginate($request->perpage);
            $report = 'no';
        }
        else
        {
            $fiscal_document = $fiscal_document->get();
            $report = $this->reportLog('لیست اسناد');
            $report = new ReportResource($report);
        }
        return response()->json([
            "message" => 'لیست اسناد موردنظر با موفقیت دریافت شد',
            "report" =>$report,
            "data"=>FiscalDocumentResource::collection($fiscal_document)->response()->getData()
        ], 200);
    }

    public function show(FiscalDocument $fiscalDocument)
    {
        return response()->json([
            "message" => 'اطلاعات سند با موفقیت دریافت شد',
            "data"=> new FiscalDocumentResource($fiscalDocument)
        ], 200);
    }

    public function exportPaymentInstruction(FiscalDocument $fiscalDocument)
    {
        return response()->json([
            "message" => 'اطلاعات دستور پرداخت جهت چاپ باموفقیت دریافت شد',
            "data"=> new FiscalDocumentResource($fiscalDocument)
        ], 200);
    }

    public function delete(Request $request)
    {
        $items = explode(',',$request->items);
        foreach ($items as $item)
        {
            $fiscal_document = FiscalDocument::find($item);
            if ($fiscal_document->cheque_sheet->status == '2')
            {
                return response()->json([
                    "message" => 'به دلیل اختصاص برگ چک شماره'.' '. $fiscal_document->cheque_sheet->cheque_number .' '.'از'.$fiscal_document->cheque_sheet->bank->title.' '.'به این سند امکان حذف سند وجود ندارد . لطفا ابتدا برگ چک الصاقی را باطل و مجددا برای حذف سند تلاش نمایید ',
                ], 200);
            }
            else
            {
                foreach ($fiscal_document->fiscal_document_item()->get() as $item)
                {
                    $item->delete();
                }
                $fiscal_document->delete();
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
            'role'=>'admin',
            'data'=>$date,
            'time'=>$time,
            'row'=>mt_rand('11111','99999')
        ]);

        return $reportData;
    }
}
