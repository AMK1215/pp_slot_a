<?php

namespace App\Services\PPSlot;

use Illuminate\Support\Facades\Http;
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
        $params = [
            'secureLogin' => $this->secureLogin,
            'options' => implode(',', $options), // optional fields such as GetFeatures, GetFrbDetails, etc.
        ];

        // Generate hash
        $hash = PPSlotHelper::generateHash($params, $this->secretKey);
        $params['hash'] = $hash;

        // Make API request
        $response = Http::asForm()->post($this->integrationApiUrl . '/getCasinoGames', $params);

        if ($response->successful()) {
            return $response->json();
        }

        return ['error' => $response->status(), 'message' => 'Failed to retrieve game list.'];
    }
}