<?php

namespace App\Providers;

use App\Services\CsrfTokenService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class CsrfServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(CsrfTokenService::class, function ($app) {
            return new CsrfTokenService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Add a Blade directive for CSRF token
        Blade::directive('csrfToken', function () {
            return '<?php echo csrf_token(); ?>';
        });

        // Add a Blade directive for CSRF meta tag
        Blade::directive('csrfMeta', function () {
            return '<meta name="csrf-token" content="<?php echo csrf_token(); ?>">';
        });
    }
}
