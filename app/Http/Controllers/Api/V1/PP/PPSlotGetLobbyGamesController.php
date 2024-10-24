<?php

namespace App\Http\Controllers\Api\V1\PP;

use App\Http\Controllers\Controller;
use App\Services\PPSlot\PPSlotGetLobbyGamesService;
use Illuminate\Http\Request;

class PPSlotGetLobbyGamesController extends Controller
{
    protected $lobbyGamesService;

    public function __construct(PPSlotGetLobbyGamesService $lobbyGamesService)
    {
        $this->lobbyGamesService = $lobbyGamesService;
    }

    /**
     * Get the list of lobby games from Pragmatic Play.
     */
    public function getLobbyGames(Request $request)
    {
        // Get categories from the request, defaulting to 'all'
        $categories = $request->input('categories', ['all']);

        // Get country code if provided
        $country = $request->input('country');

        // Call service to get the lobby games
        $response = $this->lobbyGamesService->getLobbyGames($categories, $country);

        return response()->json($response);
    }
}