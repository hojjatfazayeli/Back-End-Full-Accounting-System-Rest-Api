<?php

namespace App\Models;

use App\Enums\AccountStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory,SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable =
        [
            'uuid',
            'title',
            'totalcode',
            'specificcode',
            'detailedcode',
            'need_entity',
            'status_account',
            'account_groupe_id'
        ];

    public function account_groupe()
    {
        return $this->belongsTo(AccountGroupe::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function fiscalyesr()
    {
        return $this->belongsTo(FiscalYear::class);
    }

    public function cheques()
    {
        return $this->hasMany(Cheque::class);
    }

    public function cheque_sheets()
    {
        return $this->hasMany(ChequeSheet::class);
    }

    public function account_subscriber()
    {
        return $this->belongsTo(AccountSubScriber::class,'account_id','id');
    }

    public function fiscal_document_item()
    {
        return $this->hasMany(FiscalDocumentItem::class , 'account_id' , 'id');
    }

    protected $casts =
        [
            'status_account'=>AccountStatusEnum::class
        ];

    protected $hidden =
        [
          'account_groupe_id',
          'deleted_at',
          'admin_id'
        ];
}
