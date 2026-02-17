<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(): \Inertia\Response
    {
        $user = Auth::user();
        $tasks = $user->tasks();

        $todayDeadlines = (clone $tasks)
            ->whereDate('due_date', today())
            ->where('status', '!=', TaskStatus::Completed)
            ->count();

        $tomorrowDeadlines = (clone $tasks)
            ->whereDate('due_date', today()->addDay())
            ->where('status', '!=', TaskStatus::Completed)
            ->count();

        return Inertia::render(
            'Dashboard',
            [
                'stats' => [
                    'total' => (clone $tasks)->count(),
                    'pending' => (clone $tasks)->where('status', TaskStatus::Pending)->count(),
                    'in_progress' => (clone $tasks)->where('status', TaskStatus::InProgress)->count(),
                    'completed' => (clone $tasks)->where('status', TaskStatus::Completed)->count(),
                ],
                'recent_tasks' => (clone $tasks)
                    ->latest()
                    ->limit(5)
                    ->get(['id', 'title', 'status', 'due_date']),
                'deadlines' => [
                    'today' => $todayDeadlines,
                    'tomorrow' => $tomorrowDeadlines,
                    'today_tasks' => (clone $tasks)
                        ->whereDate('due_date', today())
                        ->where('status', '!=', TaskStatus::Completed)
                        ->get(['id', 'title']),
                    'tomorrow_tasks' => (clone $tasks)
                        ->whereDate('due_date', today()->addDay())
                        ->where('status', '!=', TaskStatus::Completed)
                        ->get(['id', 'title']),
                ],
            ],
        );
    }
}
