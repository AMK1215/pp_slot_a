<?php

namespace App\Enums;

enum PPSlotWebhookResponseCode: int
{
    case Success = 0;
    case AuthenticationFailed = 1;
    case GameRoundIdIsNotFound = 2;
    case ValidationFailed = 3;
    case InvalidHashCode = 5;
    case BadParameters = 7;
    case IncompleteGame = 10;
    case InternalServerError = 100;
}