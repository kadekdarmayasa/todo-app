<?php

namespace App\Services;

use App\Enums\StatusEnum;
use App\Models\Task;
use App\Repositories\TaskRepository;

/**
 * Class TaskService
 * Service class for handling business logic related to tasks.
 *
 * @package App\Services
 */
class TaskService
{
    /**
     * TaskService constructor.
     * @param TaskRepository $repository The repository instance for task data access and manipulation.
     */
    public function __construct(private readonly TaskRepository $repository)
    {
    }

    /**
     * Get tasks stats for a specific user.
     *
     * @param int $userId The ID of the user to get stats for.
     * @return array An associative array containing total tasks, pending tasks, in-progress tasks, and completed tasks counts.
     */
    public function getTaskStats(int $userId): array
    {
        $tasks = $this->repository->getAllTasksForUser($userId);

        return [
            'totalTask' => $tasks->count(),
            'totalPending' => $tasks->where('status', StatusEnum::Pending->value)->count(),
            'totalInProgress' => $tasks->where('status', StatusEnum::InProgress->value)->count(),
            'totalCompleted' => $tasks->where('status', StatusEnum::Completed->value)->count(),
        ];
    }

    /**
     * Get all tasks for a specific user with optional search and filters.
     *
     * @param int $userId The ID of the user to get tasks for.
     * @param string $search Optional search term to filter tasks by title or description.
     * @param array $filters Optional filters for priority, status, and due date.
     * @return \Illuminate\Database\Eloquent\Collection A collection of tasks matching the criteria.
     */
    public function getAllTasksForUser(int $userId, string $search = '', array $filters = [])
    {
        return $this->repository->getAllTasksForUser($userId, $search, $filters);
    }

    /**
     * Create a new task for a specific user.
     *
     * @param array $data The validated data for creating the task.
     * @param int $userId The ID of the user to associate the task with.
     * @return \App\Models\Task The created task model instance.
     */
    public function createTask(array $data, int $userId): Task
    {
        $data['user_id'] = $userId;

        return $this->repository->create($data);
    }

    /**
     * Update an existing task.
     *
     * @param int $taskId The ID of the task to update.
     * @param array $data The validated data for updating the task.
     * @return \App\Models\Task The updated task model instance.
     */
    public function updateTask(int $taskId, array $data): Task
    {
        return $this->repository->update($taskId, $data);
    }

    /**
     * Delete a task by its ID.
     *
     * @param int $taskId The ID of the task to delete.
     * @return bool True if the task was successfully deleted, false otherwise.
     */
    public function deleteTask(int $taskId): bool
    {
        return $this->repository->delete($taskId);
    }
}
