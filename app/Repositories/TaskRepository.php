<?php

namespace App\Repositories;

use App\Models\Task;

/**
 * Class TaskRepository
 * Repository class for managing Task model data access and manipulation.
 *
 * @package App\Repositories
 */
class TaskRepository extends BaseRepository
{
    public function __construct(Task $task)
    {
        return parent::__construct($task);
    }

    /**
     * Get all tasks for a specific user.
     *
     * @param int $userId
     * @param string $search
     * @param array $filters ['priority', 'status', 'due_date']
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllTasksForUser(int $userId, string $search = '', array $filters = [])
    {
        $query = $this->model->where('user_id', $userId);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q
                  ->where('title', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%");
            });
        }

        foreach ($filters as $key => $value) {
            if (!empty($value)) {
                $query->where($key, $value);
            }
        }

        return $query->orderBy('due_date')->get();
    }
}
