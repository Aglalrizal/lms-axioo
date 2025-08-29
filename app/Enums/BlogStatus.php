<?php

namespace App\Enums;

use App\Traits\EnumHelper;
use App\Enums\LabelledEnum;

enum BlogStatus: string implements LabelledEnum
{
    use EnumHelper;

    case DRAFTED = 'drafted';
    case PUBLISHED = 'published';
    // case SCHEDULED = 'scheduled';

    public function label(): string
    {
        return match ($this) {
            self::DRAFTED => 'Drafted',
            self::PUBLISHED => 'Published',
            // self::SCHEDULED => 'Scheduled',
        };
    }
}
