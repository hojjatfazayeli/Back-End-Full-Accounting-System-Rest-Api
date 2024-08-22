<?php

namespace App\Enums;

enum FiscalTransactionStatusEnum:string
{
    case Pending = 'pending';

    case Accepted = 'accepted';

    case Rejected = 'rejected';
}
