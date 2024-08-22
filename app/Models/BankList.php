<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankList extends Model
{
    use HasFactory,SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable =
        [
            'name',
        ];

    public function payment_installment()
    {
        return $this->hasMany(PaymentInstallment::class , 'bank_list_id' , 'id');
    }
    public function fiscal_transaction()
    {
        return $this->hasMany(FiscalTransaction::class , 'bank_list_id' , 'id');
    }

    public function receipt()
    {
        return $this->hasMany(PaymentInstallment::class , 'bank_list_id' , 'id');
    }

    protected $hidden =
        [
            'deleted_at'
        ];

}
