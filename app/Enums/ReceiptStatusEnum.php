<?php

namespace App\Enums;

enum ReceiptStatusEnum: string
{
    case APPROVED = 'Принят';
    case REJECTED = 'Отклонен';
}
