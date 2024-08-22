<?php

namespace App\Enums;

enum InstallmentBookletStatusInstallmentEnum:string
{
    case Paid = 'paid';

    case Unpaid = 'unpaid';
}
