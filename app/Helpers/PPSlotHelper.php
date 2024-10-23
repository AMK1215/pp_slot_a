<?php

namespace App\Helpers;

class PPSlotHelper
{
    /**
     * Generate hash for Pragmatic Play API request
     */
    public static function generateHash($params, $secretKey)
    {
        // Sort parameters by keys
        ksort($params);
        $queryString = http_build_query($params);

        // Append the secret key and generate MD5 hash
        return md5($queryString . $secretKey);
    }
}