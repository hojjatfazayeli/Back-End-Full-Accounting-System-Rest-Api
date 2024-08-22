<?php

namespace App\Models;

use App\Enums\AdminStatusEmployeeEnum;
use App\Enums\AdminStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;
    protected $dates = ['deleted_at'];
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
            'status_employee',
            'status',
            'password'
        ];

        protected $casts =
            [
              'status_employee'=>AdminStatusEmployeeEnum::class,
               'status'=>AdminStatusEnum::class
            ];

    protected $hidden = [
        'password',
        'deleted_at'
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'admin_permissions')->withTimestamps();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class,'admin_roles')->withTimestamps();
    }

    public function account()
    {
        return $this->hasMany(Account::class);
    }
    public function account_group()
    {
        return $this->hasMany(AccountGroupe::class);
    }

    public function receipt()
    {
        return $this->hasMany(Receipt::class,'creator_id','id');
    }
    public function cheque()
    {
        return $this->hasMany(Cheque::class,'creator_id','id');
    }

    public function cheque_sheet()
    {
        return $this->hasMany(ChequeSheet::class);
    }

    public function subscribers()
    {
        return $this->hasMany(SubScriber::class,'creator_id','id');
    }

    public function family_sub_scribers()
    {
        return $this->hasMany(FamilySubScriber::class,'creator_id','id');

    }

    public function fiscal_year()
    {
        return $this->hasMany(FiscalYear::class);
    }

    public function fiscal_year_item()
    {
        return $this->hasMany(FiscalYearsItem::class);
    }

    public function facilities()
    {
        return $this->hasMany(Facilities::class,'creator_id','id');
    }

    public function installment_booklets()
    {
        return $this->hasMany(InstallmentBooklet::class , 'creator_id' , 'id');
    }

    public function payment_installment()
    {
        return $this->hasMany(PaymentInstallment::class , 'checker_id' ,'id');
    }

    public function fiscal_document()
    {
        return $this->hasMany(FiscalDocument::class , 'creator_id' , 'id');
    }

    public function fiscal_document_item()
    {
        return $this->hasMany(FiscalDocumentItem::class , 'creator_id' , 'id');
    }

    public function fiscal_transaction()
    {
        return $this->hasMany(FiscalTransaction::class , 'checker_id' ,'id');
    }


}
