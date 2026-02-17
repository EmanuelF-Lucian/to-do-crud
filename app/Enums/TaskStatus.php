<?php

declare(strict_types=1);

namespace App\Enums;

enum TaskStatus: string
{
    case Pending = 'pending';
    case InProgress = 'in_progress';
    case Completed = 'completed';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::InProgress => 'In Progress',
            self::Completed => 'Completed',
        };
    }

    public static function toSelectArrays(): array
    {
        return collect(self::cases())->map(fn ($case) => [
            'value' => $case->value,
            'label' => $case->label(),
        ])->toArray();
    }

    public function color(): string
    {
        return match ($this) {
            self::Pending => 'bg-yellow-200 text-yellow-900',
            self::InProgress => 'bg-blue-200 text-blue-900',
            self::Completed => 'bg-green-200 text-green-900',
        };
    }
}
