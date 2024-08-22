<?php

namespace App\Http\Resources;

use App\Models\Account;
use App\Models\Admin;
use App\Models\Facilities;
use App\Models\FiscalDocument;
use App\Models\FiscalYearsItem;
use App\Models\SubScriber;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Morilog\Jalali\Jalalian;

class DashboardDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $active_fiscal_year_item = FiscalYearsItem::where('status' , 'active')->first();
        $admins = Admin::where('status' , 'active')->get();
        $subscribers = SubScriber::where('status' , 'active')->get();
        $active_fiscal_account = Account::where('status_account' , 'active')->get();
        $fiscal_document = FiscalDocument::query();
        $facilities = Facilities::all();

        // ایجاد آرایه ای برای ذخیره تعداد facility هر ماه
        $monthly_facilities = [];

        // پرکردن آرایه با تعداد 0 برای هر ماه
        for ($month = 1; $month <= 12; $month++) {
            $monthly_facilities[$month] = 0;
        }

        // دریافت اطلاعات از دیتابیس
        $total_facilities = DB::table('facilities')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(amount_facility) as total_amount'),
            )
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month', 'asc')
            ->get();

        // به‌روزرسانی آرایه با تعداد facility مربوط به هر ماه
        foreach ($total_facilities as $facility) {
            $monthly_facilities[$facility->month] = $facility->count;
        }

        // تبدیل به فرمت خروجی مورد نظر
        $result = [];
        foreach ($monthly_facilities as $month => $count) {
            $result[] = [
                'year' => Jalalian::now()->getYear(),
                'month' => $month,
                'count' => $count,
                'total_amount' => 28900
            ];
        }


        // ایجاد آرایه ای برای ذخیره تعداد facility هر ماه
        $monthly_membershipـright = [];

        // پرکردن آرایه با تعداد 0 برای هر ماه
        for ($month = 1; $month <= 12; $month++) {
            $monthly_membershipـright[$month] = 0;
        }

        // دریافت اطلاعات از دیتابیس
        $total_membershipـright = DB::table('fiscal_transactions')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count'),
            )
            ->where('type' , 'membershipـright')
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month', 'asc')
            ->get();

        // به‌روزرسانی آرایه با تعداد facility مربوط به هر ماه
        foreach ($total_membershipـright as $membershipـright) {
            $monthly_membershipـright[$membershipـright->month] = $membershipـright->count;
        }

        // تبدیل به فرمت خروجی مورد نظر
        $result_membershipـright= [];
        foreach ($monthly_membershipـright as $month => $count) {
            $result_membershipـright[] = [
                'year' => Jalalian::now()->getYear(),
                'month' => $month,
                'count' => $count,
                'total_amount' => 363000
            ];
        }

        // ایجاد آرایه ای برای ذخیره تعداد facility هر ماه
        $monthly_participate_right = [];

        // پرکردن آرایه با تعداد 0 برای هر ماه
        for ($month = 1; $month <= 12; $month++) {
            $monthly_participate_right[$month] = 0;
        }

        // دریافت اطلاعات از دیتابیس
        $total_participate_right = DB::table('fiscal_transactions')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count'),
            )
            ->where('type' , 'participate_right')
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month', 'asc')
            ->get();

        // به‌روزرسانی آرایه با تعداد facility مربوط به هر ماه
        foreach ($total_participate_right as $participate_right) {
            $monthly_participate_right[$participate_right->month] = $participate_right->count;
        }

        // تبدیل به فرمت خروجی مورد نظر
        $result_participate_right= [];
        foreach ($monthly_participate_right as $month => $count) {
            $result_participate_right[] = [
                'year' => Jalalian::now()->getYear(),
                'month' => $month,
                'count' => $count,
                'total_amount' => 363000
            ];
        }


        // ایجاد آرایه ای برای ذخیره تعداد facility هر ماه
        $monthly_motivational = [];

        // پرکردن آرایه با تعداد 0 برای هر ماه
        for ($month = 1; $month <= 12; $month++) {
            $monthly_motivational[$month] = 0;
        }

        // دریافت اطلاعات از دیتابیس
        $total_motivational = DB::table('fiscal_transactions')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count'),
            )
            ->where('type' , 'motivational')
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month', 'asc')
            ->get();

        // به‌روزرسانی آرایه با تعداد facility مربوط به هر ماه
        foreach ($total_motivational as $motivational) {
            $monthly_motivational[$motivational->month] = $motivational->count;
        }

        // تبدیل به فرمت خروجی مورد نظر
        $result_motivational = [];
        foreach ($monthly_motivational as $month => $count) {
            $result_motivational[] = [
                'year' => Jalalian::now()->getYear(),
                'month' => $month,
                'count' => $count,
                'total_amount' => 363000
            ];
        }


        // ایجاد آرایه ای برای ذخیره تعداد facility هر ماه
        $monthly_cost = [];

        // پرکردن آرایه با تعداد 0 برای هر ماه
        for ($month = 1; $month <= 12; $month++) {
            $monthly_cost[$month] = 0;
        }

// دریافت اطلاعات از دیتابیس
        $total_cost = DB::table('fiscal_document_items')
            ->select(
                DB::raw('MONTH(fiscal_document_items.created_at) as month'),
                DB::raw('COUNT(*) as count'),
            )
            ->join('accounts', 'fiscal_document_items.account_id', '=', 'accounts.id')
            ->where('accounts.totalcode', '=', 18)
            ->groupBy(DB::raw('MONTH(fiscal_document_items.created_at)'))
            ->orderBy('month', 'asc')
            ->get();

// به‌روزرسانی آرایه با تعداد facility مربوط به هر ماه
        foreach ($total_cost as $cost) {
            $monthly_cost[$cost->month] = $cost->count;
        }

// تبدیل به فرمت خروجی مورد نظر
        $result_cost = [];
        foreach ($monthly_cost as $month => $count) {
            $result_cost[] = [
                'year' => Jalalian::now()->getYear(),
                'month' => $month,
                'count' => $count,
                'total_amount' => 4568000 *$count
            ];
        }

    $normal_fiscal_document = FiscalDocument::where('status' , 'normal')->limit(5)->get();
    $last_payments = FiscalDocument::where('cheque_sheet_id','!=',null)->orderby('created_at','desc')->limit('5')->get();
        return
            [
                'info_admin' => new AdminInfoResource(Auth::user()),
                'info_dashboard' =>
                    [
                        'widgets_info' =>
                        [
                            'fiscal_year' => new FiscalYearItemInfoResource($active_fiscal_year_item),
                            'count_colleague' => count($admins),
                            'count_subscriber' => count($subscribers),
                            'count_active_fiscal_account' => count($active_fiscal_account),
                            'count_normal_fiscal_document' => count($fiscal_document->where('status' , 'normal')->get()),
                            'count_selected_fiscal_document' => count($fiscal_document->where('status' , 'selected')->get()),
                            'count_definitive_fiscal_document' => count($fiscal_document->where('status' , 'definitive')->get()),
                            'total_amount_facilities' => $facilities->sum('amount_facility'),
                            'total_amount_arrears' => '269340000',
                            'total_amount_cost' => '32490800',
                            'current_balance_cash' => 93489000,
                            'amount_balance_sms' => '546009',
                        ],
                        'chart_info' =>
                        [
                            'facility' => $result,
                            'membershipـright' => $result_membershipـright,
                            'participate_right' =>$result_participate_right,
                            'motivational' =>$result_motivational,
                            'cost' => $result_cost
                        ],
                        'list' =>
                        [
                            'last_normal_fiscal_document' => FiscalDocumentResource::collection($normal_fiscal_document),
                            'last_payments' => FiscalDocumentResource::collection($last_payments)
                        ]
                    ]
            ];
    }
}
