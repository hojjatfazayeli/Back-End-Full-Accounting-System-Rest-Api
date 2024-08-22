<?php

namespace App\Models;

use App\Enums\FiscalYearStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FiscalYear extends Model
{
    use HasFactory,SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable =
        [
            'uuid',
            'title',
            'year',
            'start_date',
            'end_date',
            'status',
        ];

    public function accountgroupes()
    {
        return $this->hasMany(AccountGroupe::class);
    }

    public function fiscal_year_item()
    {
        return $this->hasMany(FiscalYearsItem::class);
    }

    public function account()
    {
        return $this->hasMany(Account::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    protected $casts =
        [
          'status'=> FiscalYearStatusEnum::class
        ];

}
