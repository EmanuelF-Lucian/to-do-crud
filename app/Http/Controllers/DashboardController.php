<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\GetDashboardData;
use App\Enums\TaskStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(GetDashboardData $action): \Inertia\Response
    {

        return Inertia::render(
            'Dashboard',
            $action->execute(Auth::user())
        );
    }
}
