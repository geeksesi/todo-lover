<?php

namespace Geeksesi\TodoLover;

use Geeksesi\TodoLover\Models\Label;
use Geeksesi\TodoLover\Models\Task;
use Geeksesi\TodoLover\Observers\LabelObserver;
use Geeksesi\TodoLover\Observers\TaskObserver;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class TodoLoverServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Route::middlewareGroup("todo_lover_api", config("todo_lover.middleware", []));
        $this->registerRoutes();
        $this->loadMigrationsFrom(__DIR__ . "/../database/migrations");
        Task::observe(TaskObserver::class);
        Label::observe(LabelObserver::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . "/../config/todo_lover.php", "todo_lover");
        $this->registerOwnerModel();
    }

    public function registerOwnerModel()
    {
        if (class_exists("OwnerModel")) {
            return;
        }

        if (class_exists(config("auth.providers.users.model"))) {
            class_alias(config("auth.providers.users.model"), "OwnerModel");
        } else {
            class_alias(\Geeksesi\TodoLover\Models\User::class, "OwnerModel");
        }
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    private function registerRoutes()
    {
        Route::group(
            [
                "prefix" => "api/todo_lover",
                "middleware" => "todo_lover_api",
            ],
            function () {
                $this->loadRoutesFrom(__DIR__ . "/../config/routes/api.php");
            }
        );
    }
}
