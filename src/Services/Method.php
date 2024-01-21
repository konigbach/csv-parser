<?php

declare(strict_types=1);

namespace App\Services;

enum Method: string
{
    case Average = 'average';
    case Lowest = 'lowest';
    case Highest = 'highest';
    case Type = 'type';
}
