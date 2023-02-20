<?php

namespace Corals\Modules\Payment\Neopay;

use Corals\Modules\Payment\Common\AbstractGateway;
use Corals\Modules\Payment\Common\Models\WebhookCall;
use Corals\Modules\Payment\Neopay\Classes\JWT;
use GuzzleHttp\Client as HttpClient;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;

/**
 * Neopay Class
 */
class Gateway extends AbstractGateway
{

    use ValidatesRequests;

    public function getName()
    {
        return 'Neopay';
    }


    public function setAuthentication()
    {
        $projectId = '';
        $projectKey = '';

        $sandbox = $this->getSettings('sandbox_mode', 'true');

        if ($sandbox == 'true') {
            $projectId = $this->getSettings('sandbox_project_id');
            $projectKey = $this->getSettings('sandbox_project_key');
        } elseif ($sandbox == 'false') {
            $projectId = $this->getSettings('live_project_id');
            $projectKey = $this->getSettings('live_project_key');
        }

        $this->setProjectId($projectId);
        $this->setProjectKey($projectKey);
    }

    public function setProjectId($projectId)
    {
        return $this->setParameter('project_id', $projectId);
    }

    public function setProjectKey($projectKey)
    {
        return $this->setParameter('project_key', $projectKey);
    }

    public function getProjectId()
    {
        return $this->getParameter('project_id');
    }

    public function getProjectKey()
    {
        return $this->getParameter('project_key');
    }

    public function getPaymentViewName()
    {
        return 'Neopay::neopay_selected';
    }

    public function getPaymentRedirectContent($data = [])
    {
        tap(Validator::make($data, [
            'redirectHandler' => 'required',
            'paymentPurpose' => 'required',
            'transactionId' => 'required',
            "amount" => 'required|gt:0',
            "currency" => 'required',
        ]), function (\Illuminate\Contracts\Validation\Validator $validator) {
            $validator->validate();
        });

        $this->setAuthentication();

        $payload = array_merge([
            'projectId' => $this->getProjectId(),
            "receiverAccountNumber" => $this->getSettings('receiver_account_number'),
            "receiverName" => $this->getSettings('receiver_name'),
        ], Arr::only($data, ['paymentPurpose', 'transactionId', 'amount', 'currency']));


        $jwt = app()->make(JWT::class);
        $jwtToken = $jwt->encode($payload, $this->getProjectKey());

        $data['gateway'] = $this->getName();

        $redirectObject = encrypt($data);

        $redirectURL = url('neopay/client-redirect?object=' . $redirectObject);

        $payment_details = \ShoppingCart::get('default')->getAttribute('payment_details');
        if (is_array($payment_details) && isset($payment_details['selected_bank'])) {
            $bank = $payment_details['selected_bank'];
        } else {
            $bank = $this->getSettings('bank');
        }
        $initializationObject = array_filter([
            'other' => 'off',
            'bank' => $bank,
            'default_country' => $this->getSettings('default_country'),
            'default_language' => $this->getSettings('default_language'),
            'disable_bank' => $this->getSettings('disable_bank'),
            'payer_consent_neopay_rules' => $this->getSettings('payer_consent_neopay_rules') == 'true' ? 1 : 0,
            'client_redirect_url' => $redirectURL
        ]);

        return view('Neopay::payment_page')
            ->with(compact('jwtToken', 'initializationObject'));
    }

    public function requireRedirect()
    {
        return true;
    }

    public function getCountriesBanks($country = "")
    {


        $response = json_decode((new HttpClient())->get('https://psd2.neopay.lt/api/countries')->getBody(), true);
        $countries = collect($response);
        if ($country) {
            $countries = $countries->where('code', $country);
        }
        return $countries;

    }

    public function validateRequest($request)
    {
        if ($this->getSettings('show_banks_select', false)) {
            return $this->validate($request, [
                'payment_details.selected_bank' => 'required',
            ], [
                'payment_details.selected_bank.required' => trans('Neopay::labels.validation.select_bank'),
            ]);
        }

    }

    public static function webhookHandler(Request $request)
    {
        try {
            $webhookCall = null;


            $eventPayload = $request->input();
            $data = [
                'event_name' => 'neopay.successful_payment',
                'payload' => $eventPayload,
                'gateway' => 'Neopay'
            ];
            $webhookCall = WebhookCall::create($data);
            $webhookCall->process();
            return json_encode(['status' => 'success']);
        } catch (\Exception $exception) {

            if ($webhookCall) {
                $webhookCall->saveException($exception);
            }
            log_exception($exception, 'Webhooks', 'neopay');
        }
    }
}
