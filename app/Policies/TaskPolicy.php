<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    public function manageTask(User $user, Task $task): bool
    {
        return $user->id === $task->user_id;
    }
}
