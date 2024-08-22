<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountSubScriber extends Model
{
    use HasFactory,SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable =
        [
            'uuid',
            'type',
            'sub_scriber_id',
            'account_id'
        ];

    public function subscriber()
    {
        return $this->belongsTo(SubScriber::class,'sub_scriber_id','id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class,'account_id','id');
    }

}
