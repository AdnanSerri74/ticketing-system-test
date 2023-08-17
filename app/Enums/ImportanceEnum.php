<?php

namespace app\Enums;

enum ImportanceEnum: int
{
    case NORMAL = 1;
    case IMPORTANT = 2;
    case URGENT = 3;

    public static function values(): array
    {
        return [1, 2, 3];
    }
}