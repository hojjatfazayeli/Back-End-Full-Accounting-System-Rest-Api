<?php

namespace App\Enums;

enum PaymentInstallmentTypeEnum:string
{
    case InternetBank = 'internet_bank';
    case MobileBank = 'mobile_bank';
    case HamrahBank = 'hamrah_bank';
    case Pos = 'pos';
    case Manual = 'manual';
}
