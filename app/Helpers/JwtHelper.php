<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtHelper
{
    private static $secretKey;
    private static $algorithm = 'HS256';

    public static function init()
    {
        self::$secretKey = (string) env('JWT_SECRET', 'secret'); // Ensure the key is a string
    }

    public static function generateToken($payload)
    {
        return JWT::encode($payload, self::$secretKey, self::$algorithm);
    }

    public static function validateToken($token)
    {
        try {
            return JWT::decode($token, new Key(self::$secretKey, self::$algorithm));
        } catch (\Exception $e) {
            return false;
        }
    }
}

// Call the static initialization block
JwtHelper::init();