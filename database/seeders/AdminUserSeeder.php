<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Webpatser\Uuid\Uuid;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
                'uuid'=>Uuid::generate()->string,
                'firstname'=>'علی اصغر',
                'lastname'=>'سیدآبادی',
                'nationalcode'=>'1060587504',
                'birth_certificate_id'=>'2023-10-18 09:07:20',
                'status_marital'=>'single',
                'personal_id'=>'689133348',
                'fathername'=>'حسین',
                'place_birth'=>'شهرستان نیشابور',
                'place_issuance_birth_certificate'=>'شهرستان نیشابور',
                'birth_date'=>'1998-11-11 09:07:20',
                'date_employeement'=>'2020-12-10 09:07:20',
                'state_id'=>'11',
                'city_id'=>'1',
                'office_address'=>'خراسان رضوی - نیشابور - میدان حافظ - بولوار شهید فهمیده',
                'home_address'=>'خراسان رضوی - نیشابور - میدان حافظ - بولوار شهید فهمیده',
                'postalcode'=>'9314786414',
                'phone'=>'051-43329030',
                'mobile'=>'09367360561',
                'avatar'=>'Null',
                'password'=>Hash::make('12345678'),
                'status_employee'=>'employee',
                'status'=>'active'
        ]);
    }
}
