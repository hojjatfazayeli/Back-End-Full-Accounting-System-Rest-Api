<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FiscalDocumentItem extends Model
{
    use HasFactory,SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable =
        [
            'uuid',
            'description',
            'deptor',
            'creditor',
            'status',
            'fiscal_year',
            'fiscal_month',
            'fiscal_document_id',
            'account_id',
            'creator_id',
        ];

    public function fiscal_document()
    {
        return $this->belongsTo(FiscalDocument::class , 'fiscal_document_id' , 'id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class , 'account_id' , 'id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class , 'creator_id' , 'id');
    }

}
