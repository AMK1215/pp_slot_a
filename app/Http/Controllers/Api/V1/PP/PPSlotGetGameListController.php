<?php

namespace App\Http\Controllers\Api\V1\PP;

use App\Http\Controllers\Controller;
use App\Services\PPSlot\PPSlotGetGameListService;
use Illuminate\Http\Request;

class PPSlotGetGameListController extends Controller
{
    protected $slotService;

    public function __construct(PPSlotGetGameListService $slotService)
    {
        $this->slotService = $slotService;
    }

    /**
     * Get the list of casino games from Pragmatic Play.
     */
    public function getGameList(Request $request)
    {
        // Optional parameters to pass for additional data
        $options = $request->input('options', ['GetFeatures', 'GetFrbDetails', 'GetLines', 'GetDataTypes']);

        // Call service to get game list
        $response = $this->slotService->getGameList($options);

        return response()->json($response);
    }
}