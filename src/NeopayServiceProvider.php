<?php

namespace Corals\Modules\Payment\Neopay;

use Corals\Modules\Payment\Neopay\Providers\NeopayRouteServiceProvider;
use Illuminate\Support\ServiceProvider;
use Corals\Settings\Facades\Modules;

class NeopayServiceProvider extends ServiceProvider
{
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerModulesPackages();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(NeopayRouteServiceProvider::class);
    }

    public function registerModulesPackages()
    {
        Modules::addModulesPackages('corals/payment-neopay');
    }
}
