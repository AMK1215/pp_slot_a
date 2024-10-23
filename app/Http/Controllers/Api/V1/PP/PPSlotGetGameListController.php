<?php

namespace App\Http\Controllers\Api\V1\PP;

use App\Http\Controllers\Controller;
use App\Services\PPSlot\PPSlotGetGameListService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        // Log incoming request data
        Log::info('Incoming Get Game List request', ['request_data' => $request->all()]);

        // Optional parameters to pass for additional data
        $options = $request->input('options', ['GetFeatures', 'GetFrbDetails', 'GetLines', 'GetDataTypes']);

        // Call service to get game list and log the service response
        $response = $this->slotService->getGameList($options);

        // Log response data from the service
        Log::info('Get Game List Service response', ['response_data' => $response]);

        return response()->json($response);
    }
}