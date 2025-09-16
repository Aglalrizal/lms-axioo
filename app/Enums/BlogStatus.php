<?php

namespace App\Enums;

use App\Traits\EnumHelper;

enum BlogStatus: string implements LabelledEnum
{
    use EnumHelper;

    case DRAFTED = 'drafted';
    case PUBLISHED = 'published';
    // case SCHEDULED = 'scheduled';

    public function label(): string
    {
        return match ($this) {
            self::DRAFTED => 'Draf',
            self::PUBLISHED => 'Diterbitkan',
            // self::SCHEDULED => 'Dijadwalkan',
        };
    }
}
