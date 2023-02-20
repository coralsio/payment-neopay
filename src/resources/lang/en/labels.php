<?php


return [
    'settings' => [
        'live_project_id' => 'Live Project Id',
        'live_project_key' => 'Live Project Key',
        'sandbox_mode' => 'Sandbox Mode',
        'sandbox_project_id' => 'Sandbox Project Id',
        'sandbox_project_key' => 'Sandbox Project Key',
        'receiver_name' => 'Receiver Name',
        'receiver_account_number' => 'Receiver Account Number',
        'payer_consent_neopay_rules' => 'Payer Consent Rules Enabled?',
        'disable_bank' => "A BIC of a banks which should not be displayed in a payment widget.['CBVILT2X', 'CBSBLT26']",
        'bank' => "Selected bank's BIC. Only one bank may be provided at a time, array is not supported.",
        'default_country' => 'Default Country. Uppercase country code in ISO 3166-1 alpha-2 format',
        'default_language' => 'Default Lang. Uppercase language code in ISO 639-1 format',
        'show_banks_select' => 'Show Banks Selection',
    ],
    'validation' => [
        'select_bank' => 'Please Select Payment Bank'
    ],
    'checkout' => [
        'available_banks' => 'Available Banks for :country'
    ]


];
