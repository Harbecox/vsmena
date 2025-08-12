<?php

namespace App\Enum;

enum Reward: string
{
    case REWARD = 'reward';
    case PENALTY  = 'penalty';

    public function label(): string
    {
        return match($this) {
            self::REWARD => 'Премия',
            self::PENALTY  => 'Штраф',
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
