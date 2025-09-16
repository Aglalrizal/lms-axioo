<?php

namespace App\Enums;

use App\Traits\EnumHelper;

enum AccessType: string implements LabelledEnum
{
    use EnumHelper;

    case FREE_TRIAL = 'free_trial';
    case FREE = 'free';
    case PAID = 'paid';

    public function label(): string
    {
        return match ($this) {
            self::FREE_TRIAL => 'Free Trial',
            self::FREE => 'Gratis',
            self::PAID => 'Berbayar',
        };
    }

    public static function toArray(): array
    {
        return array_map(
            fn ($case) => ['value' => $case->value, 'label' => $case->label()],
            self::cases()
        );
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
