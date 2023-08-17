<?php

namespace app\Core\Middleware;

use Exception;

class Middleware
{
    public const MAP = [
        'guest' => Guest::class,
        'auth' => Authenticated::class
    ];

    public const ADMIN_DASHBOARD = '/admin/dashboard';
    public const LOGIN = '/admin/login';
    public const HOME = '/';

    public static function resolve(string $key): void
    {
        if (!$key) {
            return;
        }

        $middleware = static::MAP[$key] ?? false;

        if (!$middleware) {
            throw new Exception("No matching middleware found for key '{$key}'.");
        }

        (new $middleware)->handle();
    }
}