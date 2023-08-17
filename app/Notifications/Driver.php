<?php

namespace app\Notifications;

abstract class Driver {
    abstract public function setup(): Driver;
    abstract public function content(array $attributes): Driver;
    abstract public function process(): bool;
}