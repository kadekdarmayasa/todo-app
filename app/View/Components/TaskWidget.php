<?php

namespace App\View\Components;

use App\Services\TaskService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class TaskWidget extends Component
{
    /**
     * The stats data to be passed to the view.
     */
    public array $stats = [];

    /**
     * Create a new component instance.
     */
    public function __construct(TaskService $taskService)
    {
        $this->stats = $taskService->getTaskStats(Auth::id());
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.task-widget', [
            'title' => 'Total Task',
            'stats' => $this->stats,
        ]);
    }
}
