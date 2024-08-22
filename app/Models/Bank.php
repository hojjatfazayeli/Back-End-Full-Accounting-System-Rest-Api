<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bank extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable =
        [
            'uuid',
            'title'
        ];

    public function cheques()
    {
        return $this->hasMany(Cheque::class);
    }

    public function cheque_sheets()
    {
        return $this->hasMany(ChequeSheet::class);
    }
}
