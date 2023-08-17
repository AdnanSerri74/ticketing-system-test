<?php

namespace app\Notifications;

class Notification
{
    protected Driver $driver;

    public function send(array $information): bool
    {
        $this->driver->setup();
        $this->driver->content($information);
        return $this->driver->process();
    }

    public static function driver(string $name = null): static
    {
        $instance = new static();

        $supportedDrivers = config('app')['drivers'];

        if (in_array($name, array_keys($supportedDrivers)))
            $instance->driver = $supportedDrivers[$name];

        else {
            $defaultDriverName = config('app')['default_driver'];

            $instance->driver = new $supportedDrivers[$defaultDriverName];
        }

        return $instance;
    }
}