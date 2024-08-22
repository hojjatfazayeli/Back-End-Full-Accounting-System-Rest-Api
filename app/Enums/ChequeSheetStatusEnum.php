<?php

namespace App\Enums;

enum ChequeSheetStatusEnum:string
{
    case Useless = 'useless';

    case Usable = 'usable';

    case Returned = 'returned';
}
