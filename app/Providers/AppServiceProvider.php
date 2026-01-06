<?php
namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::aliasMiddleware('role', \App\Http\Middleware\CheckRole::class);

        // OLD CODE (DEPRECATED):
        // Blade helper function untuk mendapatkan route prefix berdasarkan role
        // Ini membantu super-admin mengakses fitur yang sama dengan admin

        // Register blade helper untuk route prefix
        \Illuminate\Support\Facades\Blade::directive('roleRoute', function ($expression) {
            return "<?php echo auth()->check() && auth()->user()->role === 'super_admin' ? 'super-admin.' : 'admin.'; ?><?php echo {$expression}; ?>";
        });
    }
}
