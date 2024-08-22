<?php

namespace App\Models;

use App\Enums\PermissionStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'permissions';
    protected $dates = ['deleted_at'];
    protected $fillable =
        [
            'uuid',
            'title_fa',
            'title_en',
            'status'
        ];

    protected $casts =
        [
            'status'=>PermissionStatusEnum::class
        ];
    public function roles()
    {
        return $this->belongsToMany(Role::class,'permission_roles')->withTimestamps();
    }

    public function admins()
    {
        return $this->belongsToMany(Admin::class,'admin_permissions','admin_id','id')->withTimestamps();
    }
}
