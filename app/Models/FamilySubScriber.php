<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FamilySubScriber extends Model
{
    use HasFactory,SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable =
        [
            'uuid',
            'firstname',
            'lastname',
            'nationalcode',
            'birth_certificate_id',
            'status_marital',
            'fathername',
            'place_birth',
            'place_issuance_birth_certificate',
            'birth_date',
            'state_id',
            'city_id',
            'home_address',
            'postalcode',
            'phone',
            'mobile',
            'avatar',
            'sub_scriber_id',
            'relation',
            'life_situation'
        ];

    public function subscriber()
    {
        return $this->belongsTo(SubScriber::class,'sub_scriber_id','id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class,'creator_id','id');
    }
}
