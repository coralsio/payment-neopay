<?php

namespace Corals\Modules\Payment\Neopay;

use Corals\Foundation\Providers\BasePackageServiceProvider;
use Corals\Modules\Payment\Neopay\Providers\NeopayRouteServiceProvider;
use Corals\Settings\Facades\Modules;

class NeopayServiceProvider extends BasePackageServiceProvider
{
    /**
     * @var
     */
    protected $defer = false;
    /**
     * @var
     */
    protected $packageCode = 'corals-payment-neopay';

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function bootPackage()
    {
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function registerPackage()
    {
        $this->app->register(NeopayRouteServiceProvider::class);
    }

    public function registerModulesPackages()
    {
        Modules::addModulesPackages('corals/payment-neopay');
    }
}
