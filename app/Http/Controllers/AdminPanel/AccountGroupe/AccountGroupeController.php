<?php

namespace App\Http\Controllers\AdminPanel\AccountGroupe;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountGroupeDeleteRequest;
use App\Http\Requests\AccountGroupeStoreRequest;
use App\Http\Requests\AccountGroupeUpdateRequest;
use App\Http\Resources\AccountGroupeInfoResource;
use App\Http\Resources\ReportResource;
use App\Models\AccountGroupe;
use App\Models\Admin;
use App\Models\ReportSystem;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Webpatser\Uuid\Uuid;

class AccountGroupeController extends Controller
{
    public function index(Request $request)
    {
        $account_group = AccountGroupe::query();
        if ($request->has('orderby'))
        {
            $account_group = $account_group->orderBy('id',$request->orderby);
        }
        if ($request->has('fiscal_year'))
        {
            $account_group = $account_group->where('fiscal_year',$request->fiscal_year);
        }
        if ($request->has('title'))
        {
            $account_group = $account_group->where('title','LIKE','%'.$request->title.'%');
        }
        if ($request->has('totalcode'))
        {
            $account_group = $account_group->where('totalcode',$request->totalcode);
        }
        if ($request->has('type_account'))
        {
            $account_group = $account_group->where('type_account',$request->type_account);
        }
        if ($request->has('nature_account'))
        {
            $account_group = $account_group->where('nature_account',$request->nature_account);
        }
        if ($request->has('status_account'))
        {
            $account_group = $account_group->where('status_account',$request->status_account);
        }
        if ($request->has('perpage'))
        {
            $account_group = $account_group->paginate($request->perpage);
            $report = 'no';
        }
        else
        {
            $account_group = $account_group->get();
            $report = $this->reportLog('لیست گروه حساب');
            $report = new ReportResource($report);

        }
        return response()->json([
            "message" => 'لیست گروه حساب با موفقیت دریافت شد',
            "report" =>$report,
            "data"=>AccountGroupeInfoResource::collection($account_group)->response()->getData()
        ], 200);
    }
    public function show(AccountGroupe $accountGroupe)
    {
        return response()->json([
            "message" => 'اطلاعات گروه حساب باموفقیت دریافت شد',
            "data"=>new AccountGroupeInfoResource($accountGroupe)
        ], 200);
    }
    public function store(AccountGroupeStoreRequest $accountGroupeStoreRequest)
    {
        $account_groupe = \auth()->user()->account_group()->create($accountGroupeStoreRequest->all());
        return response()->json([
            "message" => 'گروه حساب با موفقیت ایجاد شد',
            "data"=>new AccountGroupeInfoResource($account_groupe)
        ], 200);
    }
    public function update(AccountGroupeUpdateRequest $accountGroupeUpdateRequest,AccountGroupe $accountGroupe)
    {
        $accountGroupe->update($accountGroupeUpdateRequest->all());
        return response()->json([
            "message" => 'بروزرسانی گروه حساب با موفقیت انجام شد',
            "data"=>new AccountGroupeInfoResource($accountGroupe)
        ], 200);
    }
    public function delete(Request $request)
    {
        $items = explode(',',$request->items);
        foreach ($items as $item)
        {
            $role = AccountGroupe::find($item);
            $role ? $role->delete() : false;
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
