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

        // Step 1: Sort parameters by keys in alphabetical order
        ksort($params);

        // Step 2: Append parameters into the format `key1=value1&key2=value2`
        $queryString = http_build_query($params); // http_build_query encodes the query correctly

        // Step 3: Append the secret key to the query string
        $queryStringWithKey = $queryString . $secretKey;

        // Log the generated query string before hashing
        Log::info('Query string with secret key', ['query_string_with_key' => $queryStringWithKey]);

        // Step 4: Generate the MD5 hash
        $hash = md5($queryStringWithKey);

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
//         // Log the parameters before generating hash
//         Log::info('Generating hash with params', ['params' => $params, 'secretKey' => $secretKey]);

//         // Step 1: Sort parameters by keys (alphabetical order)
//         ksort($params);

//         // Step 2: Append parameters into a query string
//         $queryString = http_build_query($params);

//         // Step 3: Append the secret key to the query string and generate the MD5 hash
//         $hash = md5($queryString . $secretKey);

//         // Log the generated hash
//         Log::info('Hash generated', ['hash' => $hash]);

//         // Step 4: Return the generated hash
//         return $hash;
//     }
// }

// class PPSlotHelper
// {
//     /**
//      * Generate hash for Pragmatic Play API request
//      */
//     public static function generateHash($params, $secretKey)
//     {
//         // Log the parameters before generating hash
//         Log::info('Generating hash with params', ['params' => $params, 'secretKey' => $secretKey]);

//         // Sort parameters by keys
//         ksort($params);
//         $queryString = http_build_query($params);

//         // Append the secret key and generate MD5 hash
//         $hash = md5($queryString . $secretKey);

//         // Log the generated hash
//         Log::info('Hash generated', ['hash' => $hash]);

//         return $hash;
//     }
// }


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