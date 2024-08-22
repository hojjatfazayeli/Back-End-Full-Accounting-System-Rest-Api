<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receipt extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable =
        [
            'uuid',
            'title',
            'receipt_number',
            'deposit_date',
            'file',
            'description',
            'fiscal_document_id',
            'bank_list_id',
            'creator_id',
            'fiscal_year',
            'fiscal_month'
        ];

    public function bank()
    {
        return $this->belongsTo(BankList::class , 'bank_list_id' , 'id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class , 'creator_id' ,'id');
    }

    public function fiscal_document()
    {
        return $this->belongsTo(FiscalDocument::class , 'fiscal_document_id' , 'id');
    }

    }
