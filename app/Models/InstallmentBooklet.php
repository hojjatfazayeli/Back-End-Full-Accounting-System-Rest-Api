<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InstallmentBooklet extends Model
{
    use HasFactory,SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable =
        [
            'uuid',
            'nature_installment',
            'type_installment',
            'payment_year',
            'payment_month',
            'amount_installment',
            'status',
            'payment_date',
            'fiscal_year',
            'fiscal_month',
            'facility_id',
            'borrower_id',
            'creator_id'
        ];

    public function facility()
    {
        return $this->belongsTo(Facilities::class,'facility_id','id');
    }

    public function subscribers()
    {
        return $this->belongsTo(SubScriber::class,'borrower_id','id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class , 'creator_id' , 'id');
    }

    public function payment_installment()
    {
        return $this->hasMany(PaymentInstallment::class , 'installment_booklet_id' , 'id');
    }

}
