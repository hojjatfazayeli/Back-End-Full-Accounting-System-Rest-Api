<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FiscalYearsItem extends Model
{
    use HasFactory,SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable =
        [
            'uuid',
            'amount_membershipـright_month',
            'amount_participate_right',
            'amount_membership_fee',
            'amount_motivational',
            'fee_percentage',
            'status',
            'fiscal_year_id'
        ];

    public function fiscal_year()
    {
        return $this->belongsTo(FiscalYear::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    protected $hidden =
        [
            'fiscal_year_id',
            'admin_id',
            'deleted_at'
        ];
}
