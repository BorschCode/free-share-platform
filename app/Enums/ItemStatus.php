<?php

namespace App\Enums;

enum ItemStatus: int
{
    // Main statuses
    case Available = 10;
    case Gifted = 20;

    /**
     * Human-readable labels
     */
    public function label(): string
    {
        return match ($this) {
            self::Available => 'Available',
            self::Gifted => 'Gifted',
        };
    }
}
