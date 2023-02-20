<?php

namespace Corals\Modules\Payment\Neopay\Http\Controllers;

use Corals\Foundation\Http\Controllers\PublicBaseController;
use Corals\Modules\Payment\Neopay\Classes\JWT;
use Corals\Modules\Payment\Payment;
use Illuminate\Http\Request;

class NeopayController extends PublicBaseController
{
    protected $gateway;

    protected function initGateway()
    {
        $gateway = Payment::create('Neopay');

        $gateway->setAuthentication();

        $this->gateway = $gateway;
    }

    public function clientRedirect(Request $request, JWT $jwt)
    {
//                dd($jwt->decode('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ0cmFuc2FjdGlvbklkIjoiMTYwMzI2NTc5MC0zNjAiLCJwYXllckFjY291bnROdW1iZXIiOiJMVDEyMzQ1Njc4OTEyMzQ1NjgiLCJjdXJyZW5jeSI6IkVVUiIsImFtb3VudCI6MC4wMSwiaWF0IjoxNjAzMjY1ODA0LCJleHAiOjE2MDMzNTIyMDQsInN0YXR1cyI6InNpZ25lZCJ9.lzp8Tu0X3bUL-1Y4mrBqPHCgnehQszZaSDFWT9Eley8',
//            null, false));

        $encryptedObject = $request->get('object');

        try {
            $objectData = decrypt($encryptedObject);
        } catch (\Exception $exception) {
            abort(404);
        }

        $this->initGateway();

        $token = $request->get('token');
        $pending = $request->get('pending');
        $canceled = $request->get('canceled');
        $data = $request->get('data');

        $payment_reference = '';
        $payment_status = '';

        if ($token) {
            try {
                $tokenDecode = $jwt->decode($token, $this->gateway->getProjectKey());

                $payment_status = 'paid';
                $payment_reference = $tokenDecode->transactionId;
            } catch (\Exception $e) {
                abort(404);
            }
        } elseif ($pending == 1) {
            try {
                $dataDecode = $jwt->decode($data, $this->gateway->getProjectKey());

                $payment_status = 'pending';
                $payment_reference = $dataDecode->transactionId;
            } catch (\Exception $e) {
                abort(404);
            }
        } elseif ($canceled == 1) {
            try {
                $dataDecode = $jwt->decode($data, $this->gateway->getProjectKey());

                $payment_status = 'canceled';
                $payment_reference = $dataDecode->transactionId;
            } catch (\Exception $e) {
                abort(404);
            }
        }

        return $objectData['redirectHandler']($objectData, $payment_reference, $payment_status);
    }
}
