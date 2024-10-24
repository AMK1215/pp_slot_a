<?php

namespace App\Services\PPSlot;

use Illuminate\Support\Facades\Http;
use App\Helpers\PPSlotHelper;
use Illuminate\Support\Facades\Log;

class PPSlotGetLobbyGamesService
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
     * Retrieve the list of casino games from the Pragmatic Play lobby.
     */
    public function getLobbyGames($categories = 'all', $country = null)
{
    if (is_string($categories)) {
         $categories = explode(',', $categories); // Convert to array
    }
    // Prepare the parameters
    $params = [
        'secureLogin' => $this->secureLogin,
        'categories' => implode(',', $categories),
        'country' => $country,
    ];

    // Generate hash
    $hash = PPSlotHelper::generateHash($params, $this->secretKey);
    $params['hash'] = $hash;

    // Log and send the API request
    Log::info('Sending API request', ['params' => $params]);

    $response = Http::withHeaders([
        'Content-Type' => 'application/x-www-form-urlencoded',
        'Host' => 'api.prerelease-env.biz',
        'Cache-Control' => 'no-cache',
    ])->asForm()->post($this->integrationApiUrl . '/getLobbyGames', $params);

    if ($response->successful()) {
        return $response->json();
    }

    // Log and handle failed response
    Log::error('API call failed', [
        'status' => $response->status(),
        'response_body' => $response->body(),
    ]);

    return ['error' => $response->status(), 'message' => 'Failed to retrieve lobby games.'];
}

//     public function getLobbyGames($categories = 'all', $country = null)
// {
//     // Check if categories is a string, if so, convert it to an array
//     if (is_string($categories)) {
//         $categories = explode(',', $categories); // Convert to array
//     }

//     $params = [
//         'secureLogin' => $this->secureLogin,
//         'categories' => implode(',', $categories), // Ensure it's an array before using implode
//         'country' => $country,
//     ];

//     // Generate hash
//     $hash = PPSlotHelper::generateHash($params, $this->secretKey);
//     $params['hash'] = $hash;

//     // Log API call before sending
//     Log::info('Sending API request', [
//         'url' => $this->integrationApiUrl . '/getLobbyGames',
//         'params' => $params
//     ]);

//     // Make API request with headers
//     $response = Http::withHeaders([
//         'Content-Type' => 'application/x-www-form-urlencoded',
//         'Host' => 'api.prerelease-env.biz',
//         'Cache-Control' => 'no-cache',
//     ])->asForm()->post($this->integrationApiUrl . '/getLobbyGames', $params);

//     // Log the response from the API
//     Log::info('API response', [
//         'status' => $response->status(),
//         'response_body' => $response->body(),
//     ]);

//     if ($response->successful()) {
//         return $response->json();
//     }

//     // Log failed response
//     Log::error('API call failed', [
//         'status' => $response->status(),
//         'response_body' => $response->body(),
//     ]);

//     return ['error' => $response->status(), 'message' => 'Failed to retrieve lobby games.'];
// }

    // public function getLobbyGames($categories, $country = null)
    // {
    //     // Prepare the parameters
    //     // Check if categories is a string, if so, convert it to an array
    // if (is_string($categories)) {
    //     $categories = explode(',', $categories); // Convert to array
    // }

    // $params = [
    //     'secureLogin' => $this->secureLogin,
    //     'categories' => implode(',', $categories), // Ensure it's an array before using implode
    //     'country' => $country,
    // ];

    //     // Generate the hash
    //     $hash = PPSlotHelper::generateHash($params, $this->secretKey);
    //     $params['hash'] = $hash;

    //     // Log request details
    //     Log::info('Sending API request for GetLobbyGames', ['params' => $params]);

    //     // Make the API request
    //     $response = Http::asForm()->post($this->integrationApiUrl . '/getLobbyGames', $params);

    //     // Log the response
    //     Log::info('API Response', ['response' => $response->body()]);

    //     if ($response->successful()) {
    //         // Log successful response
    //         Log::info('API call successful', ['response' => $response->json()]);
    //         return $response->json();
    //     }

    //     // Log failed response
    //     Log::error('API call failed', ['status' => $response->status(), 'response' => $response->body()]);

    //     return ['error' => $response->status(), 'message' => 'Failed to retrieve lobby games.'];
    // }
}