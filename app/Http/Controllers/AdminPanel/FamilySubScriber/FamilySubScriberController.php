<?php

namespace App\Http\Controllers\AdminPanel\FamilySubScriber;

use App\Http\Controllers\Controller;
use App\Http\Requests\FamilySubScriberStoreRequest;
use App\Http\Requests\FamilySubScriberUpdateRequest;
use App\Http\Resources\FamilySubScriberInfoResource;
use App\Http\Resources\ReportResource;
use App\Http\Resources\SubScriberInfoResource;
use App\Models\FamilySubScriber;
use App\Models\ReportSystem;
use App\Models\SubScriber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Webpatser\Uuid\Uuid;

class FamilySubScriberController extends Controller
{
    public function register(FamilySubScriberStoreRequest $familySubScriberStoreRequest , SubScriber $subScriber)
    {
        $familySubScriberStoreRequest['sub_scriber_id'] = $subScriber->id;
        $familysubscriber = auth()->user()->family_sub_scribers()->create($familySubScriberStoreRequest->all());
        if ($familySubScriberStoreRequest->hasFile('avatar'))
        {
            $avatarPath = Storage::putFile('/avatar' , $familySubScriberStoreRequest->avatar);
            $familysubscriber->update(['avatar' => $avatarPath]);
        }
        return response()->json([
            "message" => 'شخص مرتبط با مشترک صندوق با موفقیت ایجاد شد',
            "data"=>new FamilySubScriberInfoResource($familysubscriber)
        ], 200);
    }

    public function show(FamilySubScriber $familySubScriber)
    {
        return response()->json([
            "message" => 'اطلاعات شخص مرتبط با موفقیت دریافت شد',
            "data"=>new FamilySubScriberInfoResource($familySubScriber)
        ], 200);
    }
    public function index(Request $request , SubScriber $subScriber)
    {
        $familiessubscriber = FamilySubScriber::query()->where('sub_scriber_id',$subScriber->id);
        if ($request->has('orderby'))
        {
            $familiessubscriber = $familiessubscriber->orderBy('id',$request->orderby);
        }
        if ($request->has('relation'))
        {
            $familiessubscriber = $familiessubscriber->where('relation', $request->relation);
        }
        if ($request->has('life_situation'))
        {
            $familiessubscriber = $familiessubscriber->where('life_situation', $request->life_situation);
        }
        if ($request->has('status_marital'))
        {
            $familiessubscriber = $familiessubscriber->where('status_marital', $request->status_marital);
        }
        if ($request->has('firstname'))
        {
            $familiessubscriber = $familiessubscriber->where('firstname','LIKE','%'.$request->firstname.'%');
        }
        if ($request->has('lastname'))
        {
            $familiessubscriber = $familiessubscriber->where('lastname','LIKE','%'.$request->lastname.'%');
        }
        if ($request->has('nationalcode'))
        {
            $familiessubscriber = $familiessubscriber->where('nationalcode','LIKE','%'.$request->nationalcode.'%');
        }
        if ($request->has('mobile'))
        {
            $familiessubscriber = $familiessubscriber->where('mobile','LIKE','%'.$request->mobile.'%');
        }

        if ($request->has('perpage'))
        {
            $familiessubscriber = $familiessubscriber->paginate($request->perpage);
            $report ='no';
        }
        else
        {
            $familiessubscriber = $familiessubscriber->get();
            $report = $this->reportLog('لیست اشخاص مرتبط');
            $report = new ReportResource($report);

        }
        return response()->json([
            "message" => 'لیست اشخاص مرتبط با مشترک صندوق با موفقیت دریافت گردید',
            "report" =>$report,
            "data"=>FamilySubScriberInfoResource::collection($familiessubscriber)->response()->getData()
        ], 200);
    }
    public function update(FamilySubScriberUpdateRequest $familySubScriberUpdateRequest , FamilySubScriber $familySubScriber)
    {
        if ($familySubScriberUpdateRequest->hasFile('avatar'))
        {
            $avatarPath = Storage::putFile('/avatar' , $familySubScriberUpdateRequest->avatar);
            $familySubScriber->update(['avatar' => $avatarPath]);
        }
        $familySubScriber->update($familySubScriberUpdateRequest->except(['avatar']));

        return response()->json([
            "message" => 'اطلاعات شخص مرتبط با موفقیت بروزرسانی شد',
            "data"=>new FamilySubScriberInfoResource($familySubScriber)
        ], 200);
    }

    public function autoDestroy(Request $request)
    {
        $items = explode(',',$request->items);
        foreach ($items as $item)
        {
            $item = FamilySubScriber::find($item);
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
            'role'=>'admin',
            'data'=>$date,
            'time'=>$time,
            'row'=>mt_rand('11111','99999')
        ]);

        return $reportData;
    }


}
