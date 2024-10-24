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
    public function getLobbyGames($categories, $country = null)
    {
        // Prepare the parameters
        $params = [
            'secureLogin' => $this->secureLogin,
            'categories' => implode(',', $categories), // list of categories like 'all', 'new', 'hot'
        ];

        if ($country) {
            $params['country'] = $country; // optional country code
        }

        // Generate the hash
        $hash = PPSlotHelper::generateHash($params, $this->secretKey);
        $params['hash'] = $hash;

        // Log request details
        Log::info('Sending API request for GetLobbyGames', ['params' => $params]);

        // Make the API request
        $response = Http::asForm()->post($this->integrationApiUrl . '/getLobbyGames', $params);

        // Log the response
        Log::info('API Response', ['response' => $response->body()]);

        if ($response->successful()) {
            // Log successful response
            Log::info('API call successful', ['response' => $response->json()]);
            return $response->json();
        }

        // Log failed response
        Log::error('API call failed', ['status' => $response->status(), 'response' => $response->body()]);

        return ['error' => $response->status(), 'message' => 'Failed to retrieve lobby games.'];
    }
}