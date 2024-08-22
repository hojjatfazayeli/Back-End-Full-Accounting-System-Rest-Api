<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FiscalTransaction extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable =
        [
            'uuid',
            'type',
            'payment_type',
            'fiscal_year',
            'fiscal_month',
            'payment_date',
            'payment_amount',
            'payment_tracking_code',
            'card_number',
            'file',
            'description',
            'status',
            'bank_list_id',
            'sub_scriber_id',
            'checker_id'
        ];

    protected $hidden =
        [
            'deleted_at',
            'bank_list_id',
            'sub_scriber_id',
            'checker_id'
        ];

    public function subscriber()
    {
        return $this->belongsTo(SubScriber::class , 'sub_scriber_id' , 'id');
    }

    public function bank()
    {
        return $this->belongsTo(BankList::class , 'bank_list_id' , 'id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class , 'checker_id' , 'id');
    }
}
