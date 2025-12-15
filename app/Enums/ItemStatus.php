<?php

namespace App\Enums;

enum ItemStatus: int
{
    case Available = 10;
    case Gifted = 20;

    public function label(): string
    {
        return match ($this) {
            self::Available => 'Available',
            self::Gifted => 'Gifted',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Available => 'bg-success',
            self::Gifted => 'bg-secondary',
        };
    }

    public function isAvailable(): bool
    {
        return $this === self::Available;
    }
}
