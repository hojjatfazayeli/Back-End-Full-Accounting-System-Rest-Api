<?php

namespace App\Models;

use App\Enums\RoleStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory,SoftDeletes;
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
            'status'=>RoleStatusEnum::class
        ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'permission_roles')->withTimestamps();
    }

    public function admins()
    {
        return $this->belongsToMany(Admin::class,'admin_roles')->withTimestamps();
    }
}
