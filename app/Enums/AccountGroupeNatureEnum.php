<?php

namespace App\Enums;

enum AccountGroupeNatureEnum:string
{
    case Debtor = 'debtor';

    case Creditor = 'creditor';

    case DeptorCreditor = 'debtorcreditor';
}
