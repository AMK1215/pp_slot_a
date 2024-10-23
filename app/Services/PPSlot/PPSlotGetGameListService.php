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
    if (is_string($options)) {
        $options = explode(',', $options);
    }

    $params = [
        'secureLogin' => $this->secureLogin,
        'options' => implode(',', $options),
    ];

    // Generate hash and log it
    $hash = PPSlotHelper::generateHash($params, $this->secretKey);
    $params['hash'] = $hash;

    Log::info('Generated hash for request', ['hash' => $hash]);

    // Log API call before sending
    Log::info('Sending API request', [
        'url' => $this->integrationApiUrl . '/getCasinoGames',
        'params' => $params
    ]);

    // Make API request
    $response = Http::withHeaders([
        'Content-Type' => 'application/x-www-form-urlencoded',
        'Host' => 'api.prerelease-env.biz',
        'Cache-Control' => 'no-cache',
    ])->asForm()->post($this->integrationApiUrl . '/getCasinoGames', $params);

    if ($response->successful()) {
        Log::info('API call successful', ['response' => $response->json()]);
        return $response->json();
    }

    // Log failed response
    Log::error('API call failed', ['status' => $response->status(), 'response' => $response->body()]);

    return ['error' => $response->status(), 'message' => 'Failed to retrieve game list.'];
}

}