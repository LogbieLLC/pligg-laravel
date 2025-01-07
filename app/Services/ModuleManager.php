<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;

class ModuleManager
{
    protected $enabledModules = [];
    protected $moduleHooks = [];

    public function __construct()
    {
        $this->loadEnabledModules();
    }

    /**
     * Load enabled modules from database or cache
     */
    protected function loadEnabledModules(): void
    {
        $this->enabledModules = Cache::remember('enabled_modules', 3600, function () {
            return DB::table('modules')
                ->where('enabled', 1)
                ->get()
                ->keyBy('folder')
                ->toArray();
        });
    }

    /**
     * Check if a module is enabled
     */
    public function isEnabled(string $moduleName): bool
    {
        return isset($this->enabledModules[$moduleName]);
    }

    /**
     * Register a hook for a module
     */
    public function registerHook(string $moduleName, string $hookName, callable $callback): void
    {
        if (!$this->isEnabled($moduleName)) {
            return;
        }

        if (!isset($this->moduleHooks[$hookName])) {
            $this->moduleHooks[$hookName] = [];
        }

        $this->moduleHooks[$hookName][] = $callback;
    }

    /**
     * Execute hooks for a given location
     */
    public function executeHooks(string $hookName, array $params = []): string
    {
        if (!isset($this->moduleHooks[$hookName])) {
            return '';
        }

        $output = '';
        foreach ($this->moduleHooks[$hookName] as $callback) {
            $output .= $callback($params);
        }

        return $output;
    }

    /**
     * Load a module's configuration
     */
    public function loadConfig(string $moduleName): array
    {
        if (!$this->isEnabled($moduleName)) {
            return [];
        }

        $configPath = base_path("modules/{$moduleName}/config.php");
        if (File::exists($configPath)) {
            return require $configPath;
        }

        return [];
    }

    /**
     * Install a module
     */
    public function install(string $moduleName): bool
    {
        if ($this->isEnabled($moduleName)) {
            return false;
        }

        $modulePath = base_path("modules/{$moduleName}");
        if (!File::isDirectory($modulePath)) {
            return false;
        }

        // Run module installation script if it exists
        $installFile = "{$modulePath}/install.php";
        if (File::exists($installFile)) {
            require_once $installFile;
        }

        // Run module migrations if they exist
        if (File::isDirectory("{$modulePath}/database/migrations")) {
            $this->runMigrations($moduleName);
        }

        // Register module in database
        DB::table('modules')->insert([
            'name' => $moduleName,
            'folder' => $moduleName,
            'version' => '1.0',
            'enabled' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Clear module cache
        Cache::forget('enabled_modules');
        $this->loadEnabledModules();

        Event::dispatch("module.installed.{$moduleName}");

        return true;
    }

    /**
     * Uninstall a module
     */
    public function uninstall(string $moduleName): bool
    {
        if (!$this->isEnabled($moduleName)) {
            return false;
        }

        $modulePath = base_path("modules/{$moduleName}");

        // Run uninstall script if it exists
        $uninstallFile = "{$modulePath}/uninstall.php";
        if (File::exists($uninstallFile)) {
            require_once $uninstallFile;
        }

        // Remove module from database
        DB::table('modules')
            ->where('folder', $moduleName)
            ->delete();

        // Clear module cache
        Cache::forget('enabled_modules');
        $this->loadEnabledModules();

        Event::dispatch("module.uninstalled.{$moduleName}");

        return true;
    }

    /**
     * Run module migrations
     */
    protected function runMigrations(string $moduleName): void
    {
        $migrationPath = base_path("modules/{$moduleName}/database/migrations");
        $namespace = "Modules\\{$moduleName}\\Database\\Migrations";

        $migrator = app('migrator');
        $migrator->path($migrationPath);
        $migrator->run();
    }

    /**
     * Get all enabled modules
     */
    public function getEnabledModules(): array
    {
        return $this->enabledModules;
    }

    /**
     * Enable a module
     */
    public function enable(string $moduleName): bool
    {
        DB::table('modules')
            ->where('folder', $moduleName)
            ->update(['enabled' => 1]);

        Cache::forget('enabled_modules');
        $this->loadEnabledModules();

        Event::dispatch("module.enabled.{$moduleName}");

        return true;
    }

    /**
     * Disable a module
     */
    public function disable(string $moduleName): bool
    {
        DB::table('modules')
            ->where('folder', $moduleName)
            ->update(['enabled' => 0]);

        Cache::forget('enabled_modules');
        $this->loadEnabledModules();

        Event::dispatch("module.disabled.{$moduleName}");

        return true;
    }
}
