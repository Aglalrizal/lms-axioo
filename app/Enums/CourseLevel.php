<?php

namespace App\Enums;

use App\Enums\LabelledEnum;
use App\Traits\EnumHelper;

enum CourseLevel: string implements LabelledEnum
{
    use EnumHelper;

    case BEGINNER = 'beginner';
    case INTERMEDIATE = 'intermediate';
    case ADVANCED = 'advanced';

    public function label(): string
    {
        return match ($this) {
            self::BEGINNER => 'Dasar',
            self::INTERMEDIATE => 'Menengah',
            self::ADVANCED => 'Profesional',
        };
    }
}
