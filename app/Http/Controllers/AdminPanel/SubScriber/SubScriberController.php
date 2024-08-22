<?php

namespace App\Http\Controllers\AdminPanel\SubScriber;

use App\Http\Controllers\AdminPanel\Account\AccountController;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubScriberPasswordUpdateRequest;
use App\Http\Requests\SubScriberStoreRequest;
use App\Http\Requests\SubScriberUpdateRequest;
use App\Http\Resources\AdminInfoResource;
use App\Http\Resources\DashboardDataResource;
use App\Http\Resources\DashboardDataSubScriberResource;
use App\Http\Resources\ReportResource;
use App\Http\Resources\SubScriberInfoResource;
use App\Models\Admin;
use App\Models\ReportSystem;
use App\Models\SubScriber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Webpatser\Uuid\Uuid;

class SubScriberController extends Controller
{

    public function getDashboard()
    {
        $subscriber = Auth::user();
        return response()->json([
            "message" => 'اطلاعات داشبورد عضو باموفقیت دریافت گردید',
            "data"=> new DashboardDataSubScriberResource($subscriber)
        ], 200);
    }

    public function register(SubScriberStoreRequest $subScriberStoreRequest)
    {
        $account = new AccountController();
        $subScriberStoreRequest['password'] = Hash::make($subScriberStoreRequest->mobile);
        $subscriber = auth()->user()->subscribers()->create($subScriberStoreRequest->all());
        $account->automate_build_account([
            'title'=>'حساب حق اشتراک' . ' '. $subscriber->firstname.' '.$subscriber->lastname,
            'totalcode' =>'12',
            'status_account'=>'active',
            'type'=>'membership',
            'sub_scriber_id' => $subscriber->id
        ]);
        $account->automate_build_account([
            'title'=>'حساب اقساط وام' . ' '. $subscriber->firstname.' '.$subscriber->lastname,
            'totalcode' =>'13',
            'status_account'=>'active',
            'type'=>'facility',
            'sub_scriber_id' => $subscriber->id
        ]);
        if ($subScriberStoreRequest->hasFile('avatar'))
        {
            $avatarPath = Storage::putFile('/avatar' , $subScriberStoreRequest->avatar);
            $subscriber->update(['avatar' => $avatarPath]);
        }
        return response()->json([
            "message" => 'مشترک صندوق با موفقیت ایجاد شد',
            "data"=>new SubScriberInfoResource($subscriber)
        ], 200);
    }

    public function index(Request $request)
    {
        $subscriber = SubScriber::query();
        if ($request->has('orderby'))
        {
            $subscriber = $subscriber->orderBy('id',$request->orderby);
        }
        if ($request->has('firstname'))
        {
            $subscriber = $subscriber->where('firstname','LIKE','%'.$request->firstname.'%');
        }
        if ($request->has('lastname'))
        {
            $subscriber = $subscriber->where('lastname','LIKE','%'.$request->lastname.'%');
        }
        if ($request->has('nationalcode'))
        {
            $subscriber = $subscriber->where('nationalcode','LIKE','%'.$request->nationalcode.'%');
        }
        if ($request->has('personal_id'))
        {
            $subscriber = $subscriber->where('personal_id','LIKE','%'.$request->personal_id.'%');
        }
        if ($request->has('mobile'))
        {
            $subscriber = $subscriber->where('mobile','LIKE','%'.$request->mobile.'%');
        }
        if ($request->has('status_marital'))
        {
            $subscriber = $subscriber->where('status_marital',$request->status_marital);
        }
        if ($request->has('status_employee'))
        {
            $subscriber = $subscriber->where('status_employee',$request->status_employee);
        }
        if ($request->has('monthly_subscription'))
        {
            $subscriber = $subscriber->where('monthly_subscription',$request->monthly_subscription);
        }
        if ($request->has('membershipـfee'))
        {
            $subscriber = $subscriber->where('membershipـfee',$request->membershipـfee);
        }
        if ($request->has('participationـrights'))
        {
            $subscriber = $subscriber->where('participationـrights',$request->participationـrights);
        }
        if ($request->has('status_portion'))
        {
            $subscriber = $subscriber->where('status_portion',$request->status_portion);
        }
        if ($request->has('status'))
        {
            $subscriber = $subscriber->where('status',$request->status);
        }
        if ($request->has('perpage'))
        {
            $subscriber = $subscriber->paginate($request->perpage);
            $report = 'no';
        }
        else
        {
            $subscriber = $subscriber->get();
            $report = $this->reportLog('لیست مشترکین');
            $report = new ReportResource($report);
        }
        return response()->json([
            "message" => 'لیست مشترکین سامانه با موفقیت دریافت گردید',
            "report" =>$report,
            "data"=>SubScriberInfoResource::collection($subscriber)->response()->getData()
        ], 200);
    }

    public function show(SubScriber $subScriber)
    {
        return response()->json([
            "message" => 'اطلاعات مشترک با موفقیت دریافت شد',
            "data"=>new SubScriberInfoResource($subScriber)
        ], 200);
    }

    public function info()
    {
        $subScriber = SubScriber::find(Auth::user()->id);
        return response()->json([
            "message" => 'اطلاعات مشترک با موفقیت دریافت شد',
            "data"=>new SubScriberInfoResource($subScriber)
        ], 200);
    }

    public function update(SubScriberUpdateRequest $subScriberUpdateRequest , SubScriber $subScriber)
    {
        if ($subScriberUpdateRequest->hasFile('avatar'))
        {
            $avatarPath = Storage::putFile('/avatar' , $subScriberUpdateRequest->avatar);
            $subScriber->update(['avatar' => $avatarPath]);
        }
        $subScriber->update($subScriberUpdateRequest->except(['avatar']));

        return response()->json([
            "message" => 'مشترک صندوق با موفقیت بروزرسانی شد',
            "data"=>new SubScriberInfoResource($subScriber)
        ], 200);
    }

    public function updateWithToken(SubScriberUpdateRequest $subScriberUpdateRequest)
    {
        $subScriber = SubScriber::find(Auth::user()->id);
        if ($subScriberUpdateRequest->hasFile('avatar'))
        {
            $avatarPath = Storage::putFile('/avatar' , $subScriberUpdateRequest->avatar);
            $subScriber->update(['avatar' => $avatarPath]);
        }
        $subScriber->update($subScriberUpdateRequest->except(['avatar']));

        return response()->json([
            "message" => 'مشترک صندوق با موفقیت بروزرسانی شد',
            "data"=>new SubScriberInfoResource($subScriber)
        ], 200);
    }

    public function pass_update(SubScriberPasswordUpdateRequest $subScriberPasswordUpdateRequest , SubScriber $subScriber)
    {
        $subScriber->update(['password' => Hash::make($subScriberPasswordUpdateRequest->password)]);
        return response()->json([
            "message" => 'پسورد مشترک صندوق با موفقیت بروزرسانی شد',
            "data"=>new SubScriberInfoResource($subScriber)
        ], 200);
    }

    public function autoDestroy(Request $request)
    {
        $items = explode(',',$request->items);
        foreach ($items as $item)
        {
            $item = SubScriber::find($item);
            $item ? $item->delete(): false;

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
