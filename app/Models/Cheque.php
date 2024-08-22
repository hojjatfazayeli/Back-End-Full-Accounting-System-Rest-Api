<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cheque extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable =
        [
          'uuid',
          'creator_id',
          'bank_id',
          'account_id',
          'number_first_sheet',
          'number_last_sheet',
          'number_sheet',
          'date_received',
          'description',
          'status'
        ];
    protected $dates = ['deleted_at'];

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function cheque_sheets()
    {
        return $this->hasMany(ChequeSheet::class,'cheque_id','id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class,'creator_id','id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function facility()
    {
        return $this->belongsTo(Cheque::class,'cheque_id','id');
    }

    public function fiscal_document()
    {
        return $this->hasMany(FiscalDocument::class , 'cheque_id' , 'id');
    }

    protected $hidden =
        [
            'deleted_at',
            'account_id',
            'creator_id'
        ];

}
