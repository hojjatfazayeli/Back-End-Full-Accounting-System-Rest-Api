<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChequeSheet extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'cheque_sheets';

    protected $fillable =
        [
            'uuid',
            'cheque_number',
            'document_number',
            'series',
            'serial',
            'sayyad_id',
            'date',
            'amount',
            'national_code',
            'description',
            'status',
            'bank_id',
            'creator_id',
            'cheque_id'
        ];

    protected $dates = ['deleted_at'];

    public function cheque()
    {
        return $this->belongsTo(Cheque::class,'cheque_id','id');
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
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
        return $this->belongsTo(Facilities::class,'cheque_sheet_id','id');
    }

    public function fiscal_document()
    {
        return $this->belongsTo(FiscalDocument::class , 'cheque_sheet_id' , 'id');
    }

    protected $hidden =
        [
            'bank_id',
            'deleted_at',
            'creator_id',
            'cheque_id'
        ];
}
