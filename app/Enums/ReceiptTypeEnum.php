<?php

namespace App\Enums;

enum ReceiptTypeEnum: string
{
    case REGULAR = 'обычный';
    case PRIZED = 'призовой';
}
