<?php

namespace App\Enum;

enum PaymentMethod: string
{
    case PER_MONTH = 'per_month';
    case PER_HOUR  = 'per_hour';
    case PER_SHIFT = 'per_shift';

    public function label(): string
    {
        return match($this) {
            self::PER_MONTH => 'За месяц',
            self::PER_HOUR  => 'За час',
            self::PER_SHIFT => 'За смену',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function forSelect(): array
    {
        return array_map(fn(self $method) => [
            'id' => $method->value,
            'name' => $method->label(),
        ], self::cases());
    }

}
