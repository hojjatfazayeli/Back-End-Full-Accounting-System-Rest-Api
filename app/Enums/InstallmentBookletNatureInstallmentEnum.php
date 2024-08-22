<?php

namespace App\Enums;

enum InstallmentBookletNatureInstallmentEnum:string
{
    case Receipt = 'receipt';

    case Payment = 'payment';
}
