<?php

declare(strict_types=1);

namespace App\Services;

final readonly class CompetenceFactory
{
    public static function build(
        string $name,
        string|float $result = null,
    ): CompetenceInterface {
        if (is_numeric($result)) {
            return new CompetenceScoreType($name, (float) $result);
        }

        if (is_string($result)) {
            return new CompetenceLevelType($name, $result);
        }

        return new CompetenceUnknownType($name, $result);
    }
}
