<?php

namespace App\Http\Controllers\AdminPanel\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionStoreRequest;
use App\Http\Requests\PermissionUpdateRequest;
use App\Http\Requests\RoleStoreRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Http\Resources\PermissionInfoResource;
use App\Http\Resources\ReportResource;
use App\Http\Resources\RoleInfoResource;
use App\Models\Permission;
use App\Models\ReportSystem;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Webpatser\Uuid\Uuid;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $role = Role::query();
        if ($request->has('orderby'))
        {
            $role = $role->orderBy('id',$request->orderby);
        }
        if ($request->has('title_fa'))
        {
            $role = $role->where('title_fa','LIKE','%'.$request->title_fa.'%');
        }

        if ($request->has('perpage'))
        {
            $role = $role->paginate($request->perpage);
            $report = 'no';
        }
        else
        {
            $role = $role->get();
            $report = $this->reportLog('لیست نقش های کاربری');
            $report = new ReportResource($report);

        }
        return response()->json([
            "message" => 'لیست نقش های کاربری با موفقیت دریافت شد',
            "report" =>$report,
            "data"=>RoleInfoResource::collection($role)->response()->getData()
        ], 200);
    }

    public function store(RoleStoreRequest $roleStoreRequest)
    {
        $roleStoreRequest['uuid'] = Uuid::generate()->string;
        $role = Role::create($roleStoreRequest->all());
        return response()->json([
            "message" => 'نقش موردنظر با موفقیت ایجاد شد',
            "data"=>new RoleInfoResource($role)
        ], 200);
    }

    public function show(Role $role)
    {
        return response()->json([
            "message" => 'نقش مودنظر با موفقیت دریافت شد',
            "data"=>new RoleInfoResource($role)
        ], 200);
    }

    public function update(RoleUpdateRequest $roleUpdateRequest,Role $role)
    {
        $role->update($roleUpdateRequest->all());
        return response()->json([
            "message" => 'نقش موردنظر با موفقیت بروزرسانی شد',
            "data"=>new RoleInfoResource($role)
        ], 200);
    }

    public function assignPermission(Request $request,Role $role)
    {
        $permissions = explode(',',$request->permisssion_id);
        $role->permissions()->sync($permissions);
        return response()->json([
            "message" => 'نقش موردنظر با موفقیت بروزرسانی شد',
            "data"=>new RoleInfoResource($role)
        ], 200);
    }

    public function permissionList(Role $role)
    {
        return response()->json([
            "message" => 'مجوز دسترسی نقش مودنظر با موفقیت دریافت شد',
            "data"=>new RoleInfoResource($role)
        ], 200);
    }

    public function delete(Request $request)
    {
        $items = explode(',',$request->items);
        foreach ($items as $item)
        {
            $role = Role::find($item);
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


