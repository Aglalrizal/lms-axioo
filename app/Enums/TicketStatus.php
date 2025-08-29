<?php

namespace App\Enums;

use App\Traits\EnumHelper;

enum TicketStatus: string implements LabelledEnum
{
    use EnumHelper;

    case OPEN = 'open';
    case RESOLVED = 'resolved';
    case CLOSED = 'closed';

    public function label(): string
    {
        return match ($this) {
            self::OPEN => 'Open',
            self::RESOLVED => 'Resolved',
            self::CLOSED => 'Closed',
        };
    }
}
