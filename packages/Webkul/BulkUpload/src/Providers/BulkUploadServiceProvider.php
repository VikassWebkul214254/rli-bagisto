<?php

namespace Webkul\BulkUpload\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Webkul\BulkUpload\Http\Middleware\BulkUpload;

class BulkUploadServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        /**
         * OverRide simple Type class
         */
        $this->app->bind('Webkul\Product\Type\Simple', 'Webkul\BulkUpload\Type\Simple');

        /**
         * OverRide Virtual Type class
         */
        $this->app->bind('Webkul\Product\Type\Virtual', 'Webkul\BulkUpload\Type\Virtual');

        /**
         * OverRide Grouped Type class
         */
        $this->app->bind('Webkul\Product\Type\Grouped', 'Webkul\BulkUpload\Type\Grouped');

        /**
         * OverRide Configurable Type class
         */
        $this->app->bind('Webkul\Product\Type\Configurable', 'Webkul\BulkUpload\Type\Configurable');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->loadRoutesFrom(__DIR__ . '/../Routes/admin-routes.php');

        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'bulkUpload');

        $this->publishes([
            __DIR__ . '/../../publishable/assets' => public_path('vendor/webkul/admin/assets'),
        ], 'public');

        $router->aliasMiddleware('bulkUpload', BulkUpload::class);

        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'bulkUpload');

        // if(core()->getConfigData('bulkUpload.settings.general.status')) {
            $this->mergeConfigFrom(
                dirname(__DIR__) . '/Config/admin-menu.php', 'menu.admin'
            );
        // }

        $this->app->register(ModuleServiceProvider::class);

        $this->app->register(EventServiceProvider::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * Register Config
         */
        $this->registerConfig();
    }

    /**
     * Register package config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/system.php', 'core'
        );
    }
}
