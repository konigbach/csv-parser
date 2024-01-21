<?php

declare(strict_types=1);

namespace App\Services;

enum Type: string
{
    case Level = 'level';
    case Score = 'score';
    case Unknown = 'unknown';
}
