<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('modules', function ($app) {
            return new \App\Services\ModuleManager();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Load enabled modules from database
        try {
            $modules = DB::table('modules')
                ->where('enabled', 1)
                ->get();

            foreach ($modules as $module) {
                $this->loadModule($module);
            }
        } catch (\Exception $e) {
            // Handle database connection errors gracefully
            report($e);
        }
    }

    /**
     * Load a single module's components
     */
    protected function loadModule($module): void
    {
        $modulePath = base_path("modules/{$module->folder}");

        if (!File::isDirectory($modulePath)) {
            return;
        }

        // Load routes if they exist
        if (File::exists("{$modulePath}/routes.php")) {
            Route::middleware('web')
                ->group("{$modulePath}/routes.php");
        }

        // Load views if they exist
        if (File::isDirectory("{$modulePath}/resources/views")) {
            $this->loadViewsFrom(
                "{$modulePath}/resources/views",
                $module->folder
            );
        }

        // Load migrations if they exist
        if (File::isDirectory("{$modulePath}/database/migrations")) {
            $this->loadMigrationsFrom("{$modulePath}/database/migrations");
        }

        // Load translations if they exist
        if (File::isDirectory("{$modulePath}/resources/lang")) {
            $this->loadTranslationsFrom(
                "{$modulePath}/resources/lang",
                $module->folder
            );
        }

        // Load module service provider if it exists
        $providerClass = "Modules\\{$module->folder}\\Providers\\{$module->folder}ServiceProvider";
        if (class_exists($providerClass)) {
            $this->app->register($providerClass);
        }

        // Load module initialization file if it exists
        if (File::exists("{$modulePath}/init.php")) {
            require_once "{$modulePath}/init.php";
        }
    }
}
