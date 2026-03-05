<?php

namespace App\Enums;

/**
 * Enum PriorityEnum
 * Represents the priority levels for tasks in the application.
 *
 * @package App\Enums
 */
enum PriorityEnum: string
{
    case Low = 'low';
    case Medium = 'medium';
    case High = 'high';

    /**
     * Get the label for the priority level.
     */
    public function label(): string
    {
        return match ($this) {
            self::Low => 'Low',
            self::Medium => 'Medium',
            self::High => 'High',
        };
    }

    /**
     * Get the color associated with the priority level.
     */
    public function color(): string
    {
        return match ($this) {
            self::Low => 'green',
            self::Medium => 'yellow',
            self::High => 'red',
        };
    }
}
