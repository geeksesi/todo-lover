<?php

namespace Geeksesi\TodoLover;

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
        Route::middlewareGroup("todo_lover_api", config("todo_lover.api_middleware", []));
        Route::middlewareGroup("todo_lover_web", config("todo_lover.web_middleware", []));
        $this->registerRoutes();
        $this->loadMigrationsFrom(__DIR__ . "/../database/migrations");
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
                "prefix" => "api/" . config("todo_lover.path"),
                "middleware" => "todo_lover_api",
            ],
            function () {
                $this->loadRoutesFrom(__DIR__ . "/../config/routes/api.php");
            }
        );
        Route::group(
            [
                "prefix" => config("todo_lover.path"),
                "middleware" => "todo_lover_web",
            ],
            function () {
                $this->loadRoutesFrom(__DIR__ . "/../config/routes/web.php");
            }
        );
    }
}
