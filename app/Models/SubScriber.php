<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class SubScriber extends Model
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;
    protected $fillable =
        [
            'uuid',
            'firstname',
            'lastname',
            'nationalcode',
            'birth_certificate_id',
            'status_marital',
            'personal_id',
            'fathername',
            'place_birth',
            'place_issuance_birth_certificate',
            'birth_date',
            'date_employeement',
            'state_id',
            'city_id',
            'office_address',
            'home_address',
            'postalcode',
            'phone',
            'mobile',
            'avatar',
            'password',
            'status_employee',
            'monthly_subscription',
            'membershipـfee',
            'participationـrights',
            'status_portion',
            'motivational_benefits',
            'status',
            'creator_id'
        ];

    protected $dates = ['deleted_at'];

    protected $hidden =
        [
            'password'
        ];
    public function admin()
    {
        return $this->belongsTo(Admin::class,'creator_id','id');
    }

    public function family_subscribers()
    {
        return $this->hasMany(FamilySubScriber::class,'sub_scriber_id','id');
    }

    public function facilities()
    {
        return $this->hasMany(Facilities::class,'borrower_id','id');
    }

    public function installment_booklet()
    {
        return $this->hasMany(InstallmentBooklet::class , 'borrower_id' , 'id');
    }

    public function payment_installment()
    {
        return $this->hasMany(PaymentInstallment::class,'payer_id' , 'id');
    }

    public function account_subscriber()
    {
        return $this->hasMany(AccountSubScriber::class,'sub_scriber_id','id');
    }

    public function fiscal_transaction()
    {
        return $this->hasMany(FiscalTransaction::class , 'sub_scriber_id' , 'id');
    }


}
