<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tasks\StoreTaskRequest;
use App\Http\Requests\Tasks\UpdateTaskRequest;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

/**
 * Class TaskController
 * Controller class for handling task-related HTTP requests and responses.
 *
 * @package App\Http\Controllers
 */
class TaskController extends Controller
{
    /**
     * Inject the TaskService via constructor
     */
    public function __construct(private readonly TaskService $taskService)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $stats = $this->taskService->getTaskStats($request->user()->id);
        $tasks = $this->taskService->getAllTasksForUser(
            userId: $request->user()->id,
            search: $request->query('search', ''),
            filters: [
                'priority' => $request->query('priority', ''),
                'status' => $request->query('status', ''),
                'due_date' => $request->query('due_date', ''),
            ]
        );

        return view('tasks.index', compact('stats', 'tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created task in storage.
     *
     * @param \App\Http\Requests\Tasks\StoreTaskRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreTaskRequest $request): RedirectResponse
    {
        $this->taskService->createTask(
            data: $request->validated(),
            userId: $request->user()->id
        );

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task created successfully.');
    }

    /**
     * Show the form for editing the specified task.
     *
     * @param \App\Models\Task $task
     * @return View
     */
    public function edit(Task $task): View
    {
        Gate::authorize('update', $task);

        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified task in storage.
     *
     * @param \App\Http\Requests\Tasks\UpdateTaskRequest $request
     * @param \App\Models\Task $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateTaskRequest $request, Task $task): RedirectResponse
    {
        $this->taskService->updateTask(
            taskId: $task->id,
            data: $request->validated()
        );

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified task from storage.
     *
     * @param \App\Models\Task $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Task $task): RedirectResponse
    {
        Gate::authorize('delete', $task);

        $this->taskService->deleteTask($task->id);

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task deleted successfully.');
    }
}
