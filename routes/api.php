<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Api\V1\BannerController;
use App\Http\Controllers\Api\V1\AgentLogoController;
use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Bank\BankController;
use App\Http\Controllers\Api\V1\Game\GameController;
use App\Http\Controllers\Api\V1\PromotionController;
use App\Http\Controllers\Api\V1\Player\WagerController;

use App\Http\Controllers\Api\V1\Game\LaunchGameController;

use App\Http\Controllers\Api\Shan\ShanTransactionController;

use App\Http\Controllers\Api\V1\Player\TransactionController;

use App\Http\Controllers\Api\V1\Game\DirectLaunchGameController;
use App\Http\Controllers\Api\V1\PP\PPSlotGetGameListController;
use App\Http\Controllers\Api\V1\PP\PPSlotGetLobbyGamesController;


//login route post
Route::post('/login', [AuthController::class, 'login']);

// logout

Route::post('/logout', [AuthController::class, 'logout']);
Route::get('promotion', [PromotionController::class, 'index']);
Route::get('banner', [BannerController::class, 'index']);
Route::get('bannerText', [BannerController::class, 'bannerText']);
Route::get('popup-ads-banner', [BannerController::class, 'AdsBannerIndex']);

Route::get('gameTypeProducts/{id}', [GameController::class, 'gameTypeProducts']);
Route::get('game/gamelist/{provider_id}/{game_type_id}', [GameController::class, 'gameList']);
Route::get('allGameProducts', [GameController::class, 'allGameProducts']);
Route::get('gameType', [GameController::class, 'gameType']);
//Route::get('hotgamelist', [GameController::class, 'HotgameList']);
Route::post('Seamless/PullReport', [LaunchGameController::class, 'pullReport']);

Route::post('transactions', [ShanTransactionController::class, 'index'])->middleware('transaction');


Route::post('/get-games', [PPSlotGetGameListController::class, 'getGameList']);
Route::post('/get-lobby-games', [PPSlotGetLobbyGamesController::class, 'getLobbyGames']);

// Route::group(['prefix' => 'Seamless'], function () {
//     Route::post('GetBalance', [GetBalanceController::class, 'getBalance']);
//     // Route::group(["middleware" => ["webhook_log"]], function(){
//     Route::post('GetGameList', [LaunchGameController::class, 'getGameList']);
//     Route::post('GameResult', [GameResultController::class, 'gameResult']);
//     Route::post('Rollback', [RollbackController::class, 'rollback']);
//     //Route::post('PlaceBet', [PlaceBetController::class, 'placeBet']);
//     //Route::post('PlaceBet', [NewRedisPlaceBetController::class, 'placeBetNew']);
//     Route::post('PlaceBet', [VersionNewPlaceBetController::class, 'placeBetNew']);


//     Route::post('CancelBet', [CancelBetController::class, 'cancelBet']);
//     Route::post('BuyIn', [BuyInController::class, 'buyIn']);
//     Route::post('BuyOut', [BuyOutController::class, 'buyOut']);
//     Route::post('PushBet', [PushBetController::class, 'pushBet']);
//     Route::post('Bonus', [BonusController::class, 'bonus']);
//     Route::post('Jackpot', [JackPotController::class, 'jackPot']);
//     Route::post('MobileLogin', [MobileLoginController::class, 'MobileLogin']);
//     // });
// });

Route::group(['middleware' => ['auth:sanctum', 'checkBanned']], function () {
    Route::get('home', [AuthController::class, 'home']);

    Route::get('wager-logs', [WagerController::class, 'index']); //GSC
    Route::get('transactions', [TransactionController::class, 'index'])->middleware('transaction');


    Route::get('user', [AuthController::class, 'getUser']);
    Route::get('agent', [AuthController::class, 'getAgent']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('change-password/{player}', [AuthController::class, 'changePassword']);
    Route::post('profile', [AuthController::class, 'profile']);

    Route::group(['prefix' => 'game'], function () {
        Route::post('Seamless/LaunchGame', [LaunchGameController::class, 'launchGame']);

    });

    Route::group(['prefix' => 'direct'], function () {
        Route::post('Seamless/LaunchGame', [DirectLaunchGameController::class, 'launchGame']);
    });
});