<?php

namespace app\Core;

use app\Models\User;

class Auth
{
    protected static string|null $token = null;

    public static function token(): string
    {
        if (!static::$token)
            static::$token = Session::get('_token');

        return static::$token;
    }

    public static function user(string $currentAccessToken): User|false
    {
        return User::where(['token', $currentAccessToken])->first();
    }
}