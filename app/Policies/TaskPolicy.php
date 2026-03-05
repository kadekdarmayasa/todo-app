<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

/**
 * Class TaskPolicy
 * Policy class for managing task-related permissions.
 *
 * @package App\Policies
 */
class TaskPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the user could update the task.
     */
    public function update(User $user, Task $task): bool
    {
        return $user->id === $task->user_id;
    }

    /**
     * Determine if the user could delete the task.
     */
    public function delete(User $user, Task $task): bool
    {
        return $user->id === $task->user_id;
    }
}
