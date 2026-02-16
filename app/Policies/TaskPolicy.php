<?php

namespace App\Policies;

use App\Models\User;

class TaskPolicy
{
    public function manageTask(User $user, $task)
    {
        return $user->id === $task->user_id;
    }
}
