<?php

namespace App\Http\Controllers\AdminPanel\Permission;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionStoreRequest;
use App\Http\Requests\PermissionUpdateRequest;
use App\Http\Resources\AdminInfoResource;
use App\Http\Resources\PermissionInfoResource;
use App\Http\Resources\ReportResource;
use App\Models\Permission;
use App\Models\ReportSystem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Webpatser\Uuid\Uuid;

class PermissionsController extends Controller
{
    public function index(Request $request)
    {
        $permission = Permission::query();
        if ($request->has('orderby'))
        {
            $permission = $permission->orderBy('id',$request->orderby);
        }
        if ($request->has('title_fa'))
        {
            $permission = $permission->where('title_fa','LIKE','%'.$request->title_fa.'%');
        }

        if ($request->has('perpage'))
        {
            $permission = $permission->paginate($request->perpage);
            $report = 'no';

        }
        else
        {
            $permission = $permission->get();
            $report = $this->reportLog('لیست مجوز دسترسی');
            $report = new ReportResource($report);

        }
        return response()->json([
            "message" => 'لیست مجوز دسترسی با موفقیت دریافت شد',
            "report" =>$report,
            "data"=>PermissionInfoResource::collection($permission)->response()->getData()
        ], 200);
    }

    public function store(PermissionStoreRequest $permissionStoreRequest)
    {
        $permissionStoreRequest['uuid'] = Uuid::generate()->string;
        $permission = Permission::create($permissionStoreRequest->all());
        return response()->json([
            "message" => 'مجوز دسترسی با موفقیت ایجاد شد',
            "data"=>new PermissionInfoResource($permission)
        ], 200);
    }

    public function show(Permission $permissions)
    {
        return response()->json([
            "message" => 'مجوز دسترسی با موفقیت دریافت شد',
            "data"=>new PermissionInfoResource($permissions)
        ], 200);
    }

    public function update(PermissionUpdateRequest $permissionUpdateRequest, Permission $permissions)
    {
        $permissions->update($permissionUpdateRequest->all());
        return response()->json([
            "message" => 'مجوز دسترسی با موفقیت بروزرسانی شد',
            "data"=>new PermissionInfoResource($permissions)
        ], 200);
    }

    public function delete(Request $request)
    {
        $items = explode(',',$request->items);
        foreach ($items as $item)
        {
            $permision = Permission::find($item);
            $permision->delete();
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
