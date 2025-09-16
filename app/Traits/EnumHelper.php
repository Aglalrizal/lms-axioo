<?php

namespace App\Traits;

trait EnumHelper
{
    /**
     * Mengembalikan semua kasus enum sebagai array asosiatif.
     * Setiap elemen berisi 'value' dan 'label'.
     */
    public static function toArray(): array
    {
        return array_map(
            fn ($case) => ['value' => $case->value, 'label' => $case->label()],
            self::cases()
        );
    }

    /**
     * Mengembalikan hanya nilai (value) dari semua kasus enum.
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
