<?php

namespace app\Core;

use Exception;

class Container
{
    public array $bindings = [];

    public function bind(string $class, callable $resolver): void
    {
        $this->bindings[$class] = $resolver;
    }

    public function resolve(string $key): mixed

    {
        if (!array_key_exists($key, $this->bindings))
            throw new Exception("No matching binding found for '$key'.");

        $resolver = $this->bindings[$key];

        return call_user_func($resolver);
    }

}