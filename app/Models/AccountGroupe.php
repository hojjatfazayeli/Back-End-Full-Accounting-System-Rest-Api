<?php

namespace App\Models;

use App\Enums\AccountGroupeNatureEnum;
use App\Enums\AccountGroupeStatusEnum;
use App\Enums\AccountGroupeTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountGroupe extends Model
{
    use HasFactory,SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable =
        [
            'uuid',
            'fiscal_year',
            'title',
            'total_code',
            'type_account',
            'nature_account',
            'status_account',
            'creator_id'
        ];

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function fiscalyear()
    {
        return $this->belongsTo(FiscalYear::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    protected $casts = [
        'type_account' => AccountGroupeTypeEnum::class,
        'nature_account'=>AccountGroupeNatureEnum::class,
        'status_account'=>AccountGroupeStatusEnum::class
    ];
}
