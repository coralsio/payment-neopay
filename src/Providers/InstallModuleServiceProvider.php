<?php

namespace Corals\Modules\Payment\Neopay\Providers;

use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{
    protected function providerBooted()
    {
        $supported_gateways = \Payments::getAvailableGateways();

        $supported_gateways['Neopay'] = 'Neopay';

        \Payments::setAvailableGateways($supported_gateways);
    }
}
