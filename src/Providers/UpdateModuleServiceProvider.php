<?php

namespace Corals\Modules\Payment\Neopay\Providers;

use Corals\Foundation\Providers\BaseUpdateModuleServiceProvider;

class UpdateModuleServiceProvider extends BaseUpdateModuleServiceProvider
{
    protected $module_code = 'corals-payment-neopay';
    protected $batches_path = __DIR__ . '/../update-batches/*.php';
}
