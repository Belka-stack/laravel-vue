<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route; // IMPORTANT : Assurez-vous que cette ligne est présente !

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        // Cette section définit la limitation de débit pour l'API.
        // Elle n'est pas directement liée au problème de 404, mais elle fait partie
        // de la configuration standard.
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        // C'EST LA PARTIE ESSENTIELLE qui charge vos fichiers de routes !
        $this->routes(function () {
            // Charge les routes API :
            // - Applique le middleware 'api' (gère CORS, authentification API, etc.)
            // - Préfixe toutes les routes avec '/api/' (ex: /api/recipes)
            // - Cherche les routes dans 'routes/api.php'
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            // Charge les routes Web :
            // - Applique le middleware 'web' (gère sessions, CSRF, etc.)
            // - Cherche les routes dans 'routes/web.php'
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
