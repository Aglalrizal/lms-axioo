<?php

namespace App\Enums;

use App\Traits\EnumHelper;

enum TicketSubject: string implements LabelledEnum
{
    use EnumHelper;

    case GENERAL = 'general';
    case TECHNICAL = 'technical';
    case ACCOUNTS = 'accounts';
    case PAYMENT = 'payment';
    case OTHER = 'other';

    public function label(): string
    {
        return match ($this) {
            self::GENERAL => 'General',
            self::TECHNICAL => 'Technical',
            self::ACCOUNTS => 'Accounts',
            self::PAYMENT => 'Payment',
            self::OTHER => 'Other',
        };
    }
}
