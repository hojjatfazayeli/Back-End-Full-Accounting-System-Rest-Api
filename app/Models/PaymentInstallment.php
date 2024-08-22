<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentInstallment extends Model
{
    use HasFactory,SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable =
        [
            'uuid',
            'payment_type',
            'payment_date',
            'payment_amount',
            'payment_tracking_code',
            'card_number',
            'file',
            'description',
            'status',
            'fiscal_year',
            'fiscal_month',
            'installment_booklet_id',
            'facility_id',
            'payer_id',
            'bank_list_id',
            'checker_id'
        ];

    public function facility()
    {
        return $this->belongsTo(Facilities::class , 'facility_id' ,'id');
    }

    public function installment_booklet()
    {
        return $this->belongsTo(InstallmentBooklet::class , 'installment_booklet_id' ,'id');
    }

    public function bank()
    {
        return $this->belongsTo(BankList::class , 'bank_list_id' , 'id');
    }

    public function subscriber()
    {
        return $this->belongsTo(SubScriber::class, 'payer_id' , 'id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class , 'checker_id' ,'id');
    }

}
