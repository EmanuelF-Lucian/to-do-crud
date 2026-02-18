<?php

declare(strict_types=1);

namespace App\Actions;

use App\Enums\TaskStatus;
use App\Models\User;

class GetDashboardData
{
    /**
     * Create a new class instance.
     */
    public function execute(User $user): array
    {
        $tasks = $user->tasks();

        $today = today();
        $tomorrow = today()->addDay();

        return [
            'stats' => [
                'total'        => (clone $tasks)->count(),
                'pending'      => (clone $tasks)->where('status', TaskStatus::Pending)->count(),
                'in_progress'  => (clone $tasks)->where('status', TaskStatus::InProgress)->count(),
                'completed'    => (clone $tasks)->where('status', TaskStatus::Completed)->count(),
            ],
            'recent_tasks' => (clone $tasks)
                ->latest()
                ->limit(5)
                ->get(['id', 'title', 'status', 'due_date']),

            'deadlines' => [
                'today'          => (clone $tasks)->whereDate('due_date', $today)->where('status', '!=', TaskStatus::Completed)->count(),
                'tomorrow'       => (clone $tasks)->whereDate('due_date', $tomorrow)->where('status', '!=', TaskStatus::Completed)->count(),
                'today_tasks'    => (clone $tasks)->whereDate('due_date', $today)->where('status', '!=', TaskStatus::Completed)->get(['id', 'title']),
                'tomorrow_tasks' => (clone $tasks)->whereDate('due_date', $tomorrow)->where('status', '!=', TaskStatus::Completed)->get(['id', 'title']),
            ],
        ];
    }
}
