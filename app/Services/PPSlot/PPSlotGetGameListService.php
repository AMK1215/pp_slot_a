<?php

namespace App\Services\PPSlot;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Helpers\PPSlotHelper;

class PPSlotGetGameListService
{
    protected $providerId;
    protected $secretKey;
    protected $integrationApiUrl;
    protected $secureLogin;

    public function __construct()
    {
        $this->providerId = config('game.api.provider_id');
        $this->secretKey = config('game.api.secret_key');
        $this->integrationApiUrl = config('game.api.integration_url');
        $this->secureLogin = config('game.api.secure_login');
    }

    /**
     * Retrieve the list of casino games from Pragmatic Play.
     */
    public function getGameList($options = [])
{
    // Check if options is a string, if so, convert it to an array
    if (is_string($options)) {
        $options = explode(',', $options); // Convert to array
    }

    $params = [
        'secureLogin' => $this->secureLogin,
        'options' => implode(',', $options), // optional fields such as GetFeatures, GetFrbDetails, etc.
    ];

    // Generate hash and log it
    $hash = PPSlotHelper::generateHash($params, $this->secretKey);
    $params['hash'] = $hash;

    // Log the generated hash
    Log::info('Generated hash for request', ['hash' => $hash]);

    // Make API request
    $response = Http::asForm()->post($this->integrationApiUrl . '/getCasinoGames', $params);

    if ($response->successful()) {
        // Log successful response
        Log::info('API call successful', ['response' => $response->json()]);
        return $response->json();
    }

    // Log failed response
    Log::error('API call failed', ['status' => $response->status(), 'response' => $response->body()]);

    return ['error' => $response->status(), 'message' => 'Failed to retrieve game list.'];
}

    // public function getGameList($options = [])
    // {
    //     // Log parameters before making the request
    //     Log::info('Preparing Get Game List request', [
    //         'secureLogin' => $this->secureLogin,
    //         'options' => $options,
    //         'integrationApiUrl' => $this->integrationApiUrl
    //     ]);

    //     $params = [
    //         'secureLogin' => $this->secureLogin,
    //         'options' => implode(',', $options),
    //     ];

    //     // Generate hash and log it
    //     $hash = PPSlotHelper::generateHash($params, $this->secretKey);
    //     $params['hash'] = $hash;

    //     Log::info('Generated hash for request', ['hash' => $hash]);

    //     // Make API request
    //     $response = Http::asForm()->post($this->integrationApiUrl . '/getCasinoGames', $params);

    //     if ($response->successful()) {
    //         // Log successful response
    //         Log::info('API call successful', ['response' => $response->json()]);
    //         return $response->json();
    //     }

    //     // Log failed response
    //     Log::error('API call failed', ['status' => $response->status(), 'response' => $response->body()]);

    //     return ['error' => $response->status(), 'message' => 'Failed to retrieve game list.'];
    // }
}

// class PPSlotGetGameListService
// {
//     protected $providerId;
//     protected $secretKey;
//     protected $integrationApiUrl;
//     protected $secureLogin;

//     public function __construct()
//     {
//         $this->providerId = config('game.api.provider_id');
//         $this->secretKey = config('game.api.secret_key');
//         $this->integrationApiUrl = config('game.api.integration_url');
//         $this->secureLogin = config('game.api.secure_login');
//     }

//     /**
//      * Retrieve the list of casino games from Pragmatic Play.
//      */
//     public function getGameList($options = [])
//     {
//         $params = [
//             'secureLogin' => $this->secureLogin,
//             'options' => implode(',', $options), // optional fields such as GetFeatures, GetFrbDetails, etc.
//         ];

//         // Generate hash
//         $hash = PPSlotHelper::generateHash($params, $this->secretKey);
//         $params['hash'] = $hash;

//         // Make API request
//         $response = Http::asForm()->post($this->integrationApiUrl . '/getCasinoGames', $params);

//         if ($response->successful()) {
//             return $response->json();
//         }

//         return ['error' => $response->status(), 'message' => 'Failed to retrieve game list.'];
//     }
// }