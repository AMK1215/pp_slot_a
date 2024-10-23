<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class PPSlotHelper
{
    /**
     * Generate hash for Pragmatic Play API request
     */
    public static function generateHash($params, $secretKey)
    {
        // Log the parameters before generating hash
        Log::info('Generating hash with params', ['params' => $params, 'secretKey' => $secretKey]);

        // Sort parameters by keys
        ksort($params);
        $queryString = http_build_query($params);

        // Append the secret key and generate MD5 hash
        $hash = md5($queryString . $secretKey);

        // Log the generated hash
        Log::info('Hash generated', ['hash' => $hash]);

        return $hash;
    }
}


// class PPSlotHelper
// {
//     /**
//      * Generate hash for Pragmatic Play API request
//      */
//     public static function generateHash($params, $secretKey)
//     {
//         // Sort parameters by keys
//         ksort($params);
//         $queryString = http_build_query($params);

//         // Append the secret key and generate MD5 hash
//         return md5($queryString . $secretKey);
//     }
// }