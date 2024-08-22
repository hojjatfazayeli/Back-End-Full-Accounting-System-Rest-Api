<?php

namespace App\Http\Controllers\AdminPanel\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use App\Http\Requests\AdminStoreRequest;
use App\Http\Requests\AdminUpdateRequest;
use App\Http\Resources\AdminInfoResource;
use App\Http\Resources\DashboardDataResource;
use App\Http\Resources\SubScriberInfoResource;
use App\Http\Resources\ReportResource;
use App\Http\Resources\UserInfoNotPaymentResource;
use App\Models\Admin;
use App\Models\ReportSystem;
use App\Models\SubScriber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Webpatser\Uuid\Uuid;

class AdminController extends Controller
{


    public function getDashboard()
    {
        $admin = Auth::user();
        return response()->json([
            "message" => 'اطلاعات داشبورد مدیریت باموفقیت دریافت گردید',
            "data"=> new DashboardDataResource($admin)
        ], 200);
    }
    public function statelist()
    {
       $state =  DB::table('province_cities')->where('parent','0')->get();
        return response()->json([
            "message" => 'لیست استان ها با موفقیت دریافت گردید',
            "data"=>$state
        ], 200);
    }
    public function citylist(Request $request)
    {
        $city = DB::table('province_cities')->where('parent',$request->state_id)->get();
        return response()->json([
            "message" => 'لیست شهرها با موفقیت دریافت گردید',
            "data"=>$city
        ], 200);
    }
    public function index(Request $request)
    {
        $admins = Admin::query();
        if ($request->has('orderby'))
        {
            $admins = $admins->orderBy('id',$request->orderby);
        }
        if ($request->has('firstname'))
        {
            $admins = $admins->where('firstname','LIKE','%'.$request->firstname.'%');
        }
        if ($request->has('lastname'))
        {
            $admins = $admins->where('lastname','LIKE','%'.$request->lastname.'%');
        }
        if ($request->has('nationalcode'))
        {
            $admins = $admins->where('nationalcode','LIKE','%'.$request->nationalcode.'%');
        }
        if ($request->has('personal_id'))
        {
            $admins = $admins->where('personal_id','LIKE','%'.$request->personal_id.'%');
        }
        if ($request->has('mobile'))
        {
            $admins = $admins->where('mobile','LIKE','%'.$request->mobile.'%');
        }
        if ($request->has('status'))
        {
            $admins = $admins->where('status',$request->status);
        }
        if ($request->has('perpage'))
        {
            $admins = $admins->paginate($request->perpage);
            $report = 'no';
        }
        else
        {
            $admins = $admins->get();
            $report = $this->reportLog('لیست همکاران');
            $report = new ReportResource($report);
        }
        return response()->json([
            "message" => 'لیست همکاران با موفقیت دریافت گردید',
            "report" =>$report,
            "data"=>AdminInfoResource::collection($admins)->response()->getData()
        ], 200);

    }
    public function show(Admin $admin)
    {
        return response()->json([
            "message" => 'اطلاعات همکار با موفقیت دریافت شد',
            "data"=>new AdminInfoResource($admin)
        ], 200);
    }
    public function info()
    {
		if(Auth::user()->role == 'admin')
		{
		$admin = Admin::find(Auth::user()->id);
        return response()->json([
            "message" => 'اطلاعات همکار با موفقیت دریافت شد',
            "data"=>new AdminInfoResource($admin)
        ], 200);
		}
		if(Auth::user()->role == 'subscriber')
		{
		$subscriber = SubScriber::find(Auth::user()->id);
        return response()->json([
            "message" => 'اطلاعات مشترک با موفقیت دریافت شد',
            "data"=>new SubScriberInfoResource($subscriber)
        ], 200);
		}

    }
    public function update(AdminUpdateRequest $adminUpdateRequest,Admin $admin)
    {
        if ($adminUpdateRequest->hasFile('avatar'))
        {
            $avatarPath = Storage::putFile('/avatar' , $adminUpdateRequest->avatar);
            $admin->update(['avatar' => $avatarPath]);
        }
        $admin->update($adminUpdateRequest->except(['avatar']));

        return response()->json([
            "message" => 'اطلاعات کاربر همکار با موفقیت بروزرسانی شد',
            "data"=>new AdminInfoResource($admin)
        ], 200);
    }
    public function updateWithToken(AdminUpdateRequest $adminUpdateRequest)
    {
        $admin = Admin::find(Auth::user()->id);
        if ($adminUpdateRequest->hasFile('avatar'))
        {
            $avatarPath = Storage::putFile('/avatar' , $adminUpdateRequest->avatar);
            $admin->update(['avatar' => $avatarPath]);
        }
        $admin->update($adminUpdateRequest->except(['avatar']));

        return response()->json([
            "message" => 'اطلاعات کاربر همکار با موفقیت بروزرسانی شد',
            "data"=>new AdminInfoResource($admin)
        ], 200);
    }
    public function register(AdminStoreRequest $adminStoreRequest)
    {
        $adminStoreRequest['uuid'] = Uuid::generate()->string;
        $adminStoreRequest['password'] = Hash::make($adminStoreRequest->mobile);
        $admin = Admin::create($adminStoreRequest->all());
        if ($adminStoreRequest->hasFile('avatar'))
        {
            $avatarPath = Storage::putFile('/avatar' , $adminStoreRequest->avatar);
            $admin->update(['avatar' => $avatarPath]);
        }
        return response()->json([
            "message" => 'کاربر همکار با موفقیت ایجاد شد',
            "data"=>new AdminInfoResource($admin)
        ], 200);
    }
    public function login(AdminLoginRequest $adminLoginRequest)
    {
		if($adminLoginRequest->role == 'admin')
		{
       $user = Admin::where('mobile',$adminLoginRequest->username)->first();
		}
		if($adminLoginRequest->role == 'subscriber')
		{
       $user = SubScriber::where('mobile',$adminLoginRequest->username)->first();
       if ($user->membershipـfee == 'unpaid')
       {
           return response()->json([
               "message"=>'متاسفانه بدلیل عدم پرداخت حق عضویت اولیه حساب کاربری شما معلق می باشد',
               "data"=>new UserInfoNotPaymentResource($user)
           ],318);
       }
		}
		if($user)
		{
        if (Hash::check($adminLoginRequest->password, $user->password))
        {
		if($adminLoginRequest->role == 'admin')
		{
            $token = $user->createToken('َApi | AdminLogin');
            return response()->json([
                "message"=>'ورود مدیر باموفقیت انجام شد',
                "token"=>$token->plainTextToken,
                "data"=>new AdminInfoResource($user)
            ],200);
		}
		if($adminLoginRequest->role == 'subscriber')
		{
            $token = $user->createToken('َApi | SubscriberLogin');
            return response()->json([
                "message"=>'ورود مشترک باموفقیت انجام شد',
                "token"=>$token->plainTextToken,
                "data"=>new SubScriberInfoResource($user)
            ],200);
		}
        }
        else
        {
            return response()->json([
                "message"=>'رمز عبور اشتباه است',
            ],412);
        }
		}
		else
		{
            return response()->json([
                "message"=>'کاربری یافت نشد',
            ],314);
		}

    }
    public function logout()
    {
        $user = Auth::user();
        $user->currentAccessToken()->delete();
        return response()->json([
            "message" => 'خروج با موفقیت انجام شد',
        ], 200);
    }
    public function autoDestroy(Request $request)
    {
        $items = explode(',',$request->items);
        foreach ($items as $item)
        {
            $item = Admin::find($item);
            $item ? $item->delete(): false;

        }
        return response()->json([
            "message" => 'حذف با موفقیت انجام شد',
        ], 200);
    }
    public function assignPermission(Request $request, Admin $admin)
    {
        $permissions = explode(',',$request->permission_id);
        $admin->permissions()->sync($permissions);
        return response()->json([
            "message" => 'مجوز دسترسی همکار با موفقیت ایجاد شد',
            "data"=>new AdminInfoResource($admin)
        ], 200);
    }
    public function assignRole(Request $request, Admin $admin)
    {
        $roles = explode(',',$request->role_id);
        $admin->roles()->sync($roles);
        return response()->json([
            "message" => 'نقش همکار همکار با موفقیت ایجاد شد',
            "data"=>new AdminInfoResource($admin)
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
