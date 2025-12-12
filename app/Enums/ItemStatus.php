<?php

namespace App\Enums;

enum ItemStatus: int
{
    // Main statuses
    case Available = 10;
    case Gifted = 20;
    case Pending = 30;
    case Moderating = 31;
    case Claimed = 40;
    case Refused = 41;

    /**
     * Human-readable labels
     */
    public function label(): string
    {
        return match ($this) {
            self::Available => 'Available',
            self::Gifted => 'Gifted',
            self::Pending => 'Pending',
            self::Claimed => 'Claimed',
            self::Moderating => 'Moderating',
            self::Refused => 'Refused',
        };
    }
}
