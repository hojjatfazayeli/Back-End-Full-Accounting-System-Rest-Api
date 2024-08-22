<?php

namespace App\Enums;

enum FiscalDocumentTypeEnum:string
{
    case Installments = 'installments';
    case Facility = 'facility';
    case Normal = 'normal';

}
