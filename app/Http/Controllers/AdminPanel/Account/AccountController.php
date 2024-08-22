<?php

namespace App\Http\Controllers\AdminPanel\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountGroupeStoreRequest;
use App\Http\Requests\AccountGroupeUpdateRequest;
use App\Http\Requests\AccountStoreRequest;
use App\Http\Requests\AccountUpdateRequest;
use App\Http\Resources\AccountGroupeInfoResource;
use App\Http\Resources\AccountInfoResource;
use App\Http\Resources\ReportResource;
use App\Models\Account;
use App\Models\AccountGroupe;
use App\Models\AccountSubScriber;
use App\Models\ReportSystem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Webpatser\Uuid\Uuid;

class AccountController extends Controller
{
    public function build_detail_code($total_code)
    {
       $account =  Account::where('totalcode' , $total_code)->orderby('id','desc')->first();
        if($account)
        {
            $uniquecode = $account->detailedcode+'1';
            return str_pad($uniquecode, 6, '0', STR_PAD_LEFT);
        }
        else
        {
            return $uniquecode = '000001';
        }
    }
    public function index(Request $request)
    {
        $account = Account::query();
        if ($request->has('orderby'))
        {
            $account = $account->orderBy('id',$request->orderby);
        }
        if ($request->has('title'))
        {
            $account = $account->where('title','LIKE','%'.$request->title.'%');
        }
        if ($request->has('totalcode'))
        {
            $account = $account->where('totalcode',$request->totalcode);
        }
        if ($request->has('specificcode'))
        {
            $account = $account->where('specificcode',$request->specificcode);
        }
        if ($request->has('detailedcode'))
        {
            $account = $account->where('detailedcode',$request->detailedcode);
        }
        if ($request->has('status_account'))
        {
            $account = $account->where('status_account',$request->status_account);
        }
        if ($request->has('perpage'))
        {
            $account = $account->paginate($request->perpage);
            $report = 'no';
        }
        else
        {
            $account = $account->get();
            $report = $this->reportLog('لیست حساب');
            $report = new ReportResource($report);
            return response()->json([
                "message" => 'لیست حساب ها با موفقیت دریافت شد',
                "report" =>$report,
                "data"=>AccountInfoResource::collection($account)
            ], 200);

        }
        return response()->json([
            "message" => 'لیست حساب ها با موفقیت دریافت شد',
            "report" =>$report,
            "data"=>AccountInfoResource::collection($account)->response()->getData()
        ], 200);
    }

    public function show(Account $account)
    {
        return response()->json([
            "message" => 'اطلاعات حساب باموفقیت دریافت شد',
            "data"=>new AccountInfoResource($account)
        ], 200);
    }

    public function store(AccountStoreRequest $accountStoreRequest)
    {
        $account = \auth()->user()->account()->create($accountStoreRequest->all());
/*        AccountSubScriber::create([
            'uuid'=>Uuid::generate()->string,
            'type'=>$accountStoreRequest->type,
            'sub_scriber_id'=>$accountStoreRequest->sub_scriber_id,
            'account_id'=>$account->id
        ]);*/
        return response()->json([
            "message" => 'حساب با موفقیت ایجاد شد',
            "data"=>new AccountInfoResource($account)
        ], 200);
    }

    public function automate_build_account($account_data)
    {
        $account_groupe = AccountGroupe::where('total_code' , $account_data['totalcode'])->first();
        $account = \auth()->user()->account()->create([
            'title' => $account_data['title'],
            'totalcode' => $account_data['totalcode'],
            'specificcode' => '00',
            'detailedcode' => $this->build_detail_code($account_data['totalcode']),
            'status_account' => $account_data['status_account'],
            'account_groupe_id' => $account_groupe->id
        ]);
        AccountSubScriber::create([
            'type'=>$account_data['type'],
            'sub_scriber_id' => $account_data['sub_scriber_id'],
            'account_id' => $account->id
        ]);

    }

    public function update(AccountUpdateRequest $accountUpdateRequest ,Account $account)
    {
        $account->update($accountUpdateRequest->all());
        return response()->json([
            "message" => 'بروزرسانی حساب با موفقیت انجام شد',
            "data"=>new AccountInfoResource($account)
        ], 200);
    }

    public function delete(Request $request)
    {
        $items = explode(',',$request->items);
        foreach ($items as $item)
        {
            $role = Account::find($item);
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
