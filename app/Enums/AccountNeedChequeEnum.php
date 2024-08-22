<?php

namespace App\Enums;

enum AccountNeedChequeEnum:string
{
    case Cheque = '1';
    case Receipt = '2';
    case Both = '3';
    case Nothing = '4';
}
