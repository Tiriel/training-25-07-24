<?php

namespace App\Movie\Enum;

enum SearchType
{
    case Id;
    case Title;

    public function label(): string
    {
        return match ($this) {
            self::Id => 'i',
            self::Title => 't',
        };
    }

    public static function fromString(string $value): self
    {
        return match ($value) {
            't' => self::Title,
            'i' => self::Id,
            default => throw new \InvalidArgumentException(),
        };
    }
}
