<?php

namespace app\Enums;

enum StatusEnum: string
{
    case PENDING = 'P';
    case IN_PROGRESS = 'I';
    case CLOSED = 'C';

    public static function values(): array
    {
        return ['P', 'I', 'C'];
    }
}