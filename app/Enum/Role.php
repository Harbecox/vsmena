<?php

namespace App\Enum;

enum Role: string
{
    case A = 'a';
    case E = 'e';
    case B = 'b';
    case M = 'm';

    public function label(): string
    {
        return match($this) {
            self::A => 'Сотрудник',
            self::E  => 'Менеджер',
            self::B => 'Бухгалтер',
            self::M => 'Администратор',
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

    public static function labels(): array
    {
        return array_column(
            array_map(fn(self $method) => [
                'key'   => $method->value,
                'label' => $method->label(),
            ], self::cases()),
            'label',
            'key'
        );
    }
}
