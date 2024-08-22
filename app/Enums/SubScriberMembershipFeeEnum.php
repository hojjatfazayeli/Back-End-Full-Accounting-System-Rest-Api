<?php

namespace App\Enums;

enum SubScriberMembershipFeeEnum:string
{
    case Paid = 'paid';

    case NotPaid = 'unpaid';
}
