<?php

namespace App\Enums;

enum PaymentInstallmentStatusEnum:string
{
        case Pending = 'pending';

        case Accepted = 'accepted';

        case Rejected = 'rejected';
}
