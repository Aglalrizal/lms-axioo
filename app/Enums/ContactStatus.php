<?php

namespace App\Enums;

use App\Traits\EnumHelper;

enum ContactStatus: string implements LabelledEnum
{
    use EnumHelper;

    case OPEN = 'open';
    case REPLIED = 'replied';

    public function label(): string
    {
        return match ($this) {
            self::OPEN => 'Dibuka',
            self::REPLIED => 'Dibalas',
        };
    }
}
