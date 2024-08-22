<?php

namespace App\Enums;

enum FiscalDocumentStatusEnum:string
{
    case Normal = 'normal';

    case Selected = 'selected';

    case Definitive = 'definitive';

}
