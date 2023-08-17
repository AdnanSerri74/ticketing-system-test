<?php

namespace app\Core;

class Request
{

    public function has(string $key): bool
    {
        return array_key_exists($key, $_POST);
    }

    public function get(string $key): mixed
    {
        return $_POST[$key] ?? null;
    }

    public function query(string $key = null): mixed
    {
        $query = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY) ?? '';
        parse_str($query, $params);

        if (!$key)
            return $params;

        return array_key_exists($key, $params) ? $params[$key] : null;
    }

    public function all(bool $withSpecialAttrs = false): array
    {
        $attributes = $_POST ?? [];

        if ($withSpecialAttrs)
            return $attributes;

        foreach ($attributes as $key => $value)
            if (str_starts_with($key, '_'))
                unset($attributes[$key]);

        return $attributes;
    }

    public function uri()
    {

    }

    public function append(string $key, mixed $value)
    {

    }
}