<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Facilities extends Model
{
    use HasFactory,SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable =
        [
            'uuid',
            'borrower_id',
            'title',
            'amount_facility',
            'wage',
            'start_installment_date',
            'quantity_installments',
            'amount_first_installment',
            'amount_other_installment',
            'payment_date',
            'fiscal_year',
            'fiscal_month',
            'cheque_id',
            'cheque_sheet_id',
            'creator_id',
            'code'
        ];

    public function cheques()
    {
        return $this->belongsTo(Cheque::class,'cheque_id','id');
    }
    public function cheque_sheets()
    {
        return $this->belongsTo(ChequeSheet::class,'cheque_sheet_id','id');
    }

    public function subscriber()
    {
        return $this->belongsTo(SubScriber::class,'borrower_id','id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class,'creator_id','id');
    }

    public function installment_booklet()
    {
        return $this->hasMany(InstallmentBooklet::class,'facility_id','id');
    }

    public function payment_installments()
    {
        return $this->hasMany(PaymentInstallment::class,'facility_id' , 'id');
    }
}
