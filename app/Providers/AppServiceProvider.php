<?php

namespace App\Providers;

use App\Models\Task;
use App\Repositories\TaskRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        /**
         * Bind the TaskRepository interface to its implementation in the service container.
         */
        $this->app->bind(TaskRepository::class, function ($app) {
            return new TaskRepository(new Task());
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
