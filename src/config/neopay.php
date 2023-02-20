<?php

return [
    'name' => 'Neopay',
    'key' => 'payment_neopay',
    'support_reservation' => false,
    'support_ecommerce' => true,
    'support_marketplace' => true,
    'support_subscription' => false,
    'support_online_refund' => false,
    'manage_remote_plan' => false,
    'require_token_confirm' => true,
    'manage_remote_product' => false,
    'manage_remote_sku' => false,
    'manage_remote_order' => false,
    'supports_swap' => false,
    'supports_swap_in_grace_period' => false,
    'require_invoice_creation' => false,
    'require_plan_activation' => false,
    'capture_payment_method' => false,
    'require_default_payment_set' => false,
    'can_update_payment' => false,
    'create_remote_customer' => false,
    'require_payment_token' => false,

    'settings' => [
        'live_project_id' => [
            'label' => 'Neopay::labels.settings.live_project_id',
            'type' => 'text',
            'required' => false,
        ],
        'live_project_key' => [
            'label' => 'Neopay::labels.settings.live_project_key',
            'type' => 'text',
            'required' => false,
        ],
        'sandbox_mode' => [
            'label' => 'Neopay::labels.settings.sandbox_mode',
            'type' => 'boolean'
        ],
        'sandbox_project_id' => [
            'label' => 'Neopay::labels.settings.sandbox_project_id',
            'type' => 'text',
            'required' => false,
        ],
        'sandbox_project_key' => [
            'label' => 'Neopay::labels.settings.sandbox_project_key',
            'type' => 'text',
            'required' => false,
        ],
        'receiver_name' => [
            'label' => 'Neopay::labels.settings.receiver_name',
            'type' => 'text',
            'required' => true,
        ],
        'receiver_account_number' => [
            'label' => 'Neopay::labels.settings.receiver_account_number',
            'type' => 'text',
            'required' => true,
        ],
        'payer_consent_neopay_rules' => [
            'label' => 'Neopay::labels.settings.payer_consent_neopay_rules',
            'type' => 'boolean'
        ],
        'disable_bank' => [
            'label' => 'Neopay::labels.settings.disable_bank',
            'type' => 'text',
            'required' => false,
        ],
        'bank' => [
            'label' => 'Neopay::labels.settings.bank',
            'type' => 'text',
            'required' => false,
        ],
        'default_country' => [
            'label' => 'Neopay::labels.settings.default_country',
            'type' => 'text',
            'required' => false,
        ],
        'default_language' => [
            'label' => 'Neopay::labels.settings.default_language',
            'type' => 'text',
            'required' => false,
        ],
        'show_banks_select' => [
            'label' => 'Neopay::labels.settings.show_banks_select',
            'type' => 'boolean'
        ],
    ],
    'events' => [
        'successful_payment' => \Corals\Modules\Payment\Neopay\Job\HandleSuccessfullPayment::class,
    ],
    'webhook_handler' => \Corals\Modules\Payment\Neopay\Gateway::class,

];
