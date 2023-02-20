<?php

namespace Corals\Modules\Payment\Neopay\Exception;

use Corals\Modules\Payment\Common\Exception\WebhookFailed;
use Corals\Modules\Payment\Common\Models\WebhookCall;

class NeopayWebhookFailed extends WebhookFailed
{

    public static function invalidNeopayPayload(WebhookCall $webhookCall)
    {
        return new static(trans('Neopay::exception.invalid_neopay_payload', ['arg' => $webhookCall->id]));
    }

    public static function invalidSuccessStatus(WebhookCall $webhookCall)
    {
        return new static(trans('Neopay::exception.invalid_success_status', ['arg' => $webhookCall->id]));
    }
}
