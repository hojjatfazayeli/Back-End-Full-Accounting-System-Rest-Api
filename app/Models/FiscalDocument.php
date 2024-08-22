<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FiscalDocument extends Model
{
    use HasFactory,SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable =
        [
            'uuid',
            'nature_document',
            'type_document',
            'payment_year',
            'payment_month',
            'amount_installment',
            'status',
            'fiscal_year',
            'fiscal_month',
            'facility_id',
            'borrower_id',
            'creator_id',
            'description',
            'deptor',
            'creditor',
            'status',
            'fiscal_document_id',
            'account_id',
            'cheque_id',
            'cheque_sheet_id',
            'title',
            'document_date',
            'serial_code',
            'payment_date',
        ];

    public function fiscal_document_item()
    {
        return $this->hasMany(FiscalDocumentItem::class, 'fiscal_document_id' ,'id');
    }

    public function receipt()
    {
        return $this->belongsTo(Receipt::class , 'fiscal_document_id' , 'id');
    }
    public function cheque()
    {
        return $this->belongsTo(Cheque::class , 'cheque_id' , 'id');
    }

    public function cheque_sheet()
    {
        return $this->belongsTo(ChequeSheet::class , 'cheque_sheet_id' , 'id');

    }

    public function admin()
    {
        return $this->belongsTo(Admin::class , 'creator_id' , 'id');
    }
}
