<?php

namespace App\Helpers;

class NetworkHelper
{
    public static function ensureInternet()
    {
        $connected = @fsockopen("8.8.8.8", 53);
        if (!$connected) {
            throw new \Exception('No internet connection 123');
        }
    }
}