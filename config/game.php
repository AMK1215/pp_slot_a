<?php

return [
    'api' => [
        'provider_id' => env('PROVIDER_ID'),           // Pragmatic Play Provider ID
        'secure_login' => env('SECURE_LOGIN'),             // Pragmatic Play API SECURE_LOGIN_NAME
        'secret_key' => env('PP_SECRET_KEY'),         // Secret key for API
        'launch_url' => env('GAME_LAUNCHAPI'),        // Game launch API URL
        'integration_url' => env('URL_INTEGRATION_HTTP_SERVICE'), // Integration HTTP Service URL
        'datafeed_environments' => env('URL_DATAFEED_ENVIRONMENTS_LIST'), // Datafeeds environments URL
    ],
];