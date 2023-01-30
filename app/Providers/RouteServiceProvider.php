<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(function(){
                 require base_path('routes/api/admin.php');
                 require base_path('routes/api/appimage.php');
                 require base_path('routes/api/auth.php');
                 require base_path('routes/api/blackBarText.php');
                 require base_path('routes/api/carModel.php');
                 require base_path('routes/api/carBrand.php');
                 require base_path('routes/api/category.php');
                 require base_path('routes/api/config.php');
                 require base_path('routes/api/ecsurvey.php');
                 require base_path('routes/api/faq.php');
                 require base_path('routes/api/linktreeLinks.php');
                 require base_path('routes/api/location.php');
                 require base_path('routes/api/mail.php');
                 require base_path('routes/api/metaData.php');
                 require base_path('routes/api/order.php');
                 require base_path('routes/api/pdf.php');
                 require base_path('routes/api/product.php');
                 require base_path('routes/api/productCarModel.php');
                 require base_path('routes/api/productImage.php');
                 require base_path('routes/api/retiroOption.php');
                 require base_path('routes/api/searchHistory.php');
                 require base_path('routes/api/sorteo.php');
                 require base_path('routes/api/state.php');
                 require base_path('routes/api/stats.php');
                 require base_path('routes/api/survey.php');
                 require base_path('routes/api/TelegramNotificationLog.php');
                 require base_path('routes/api/trackEvent.php');
            });
    }
}
