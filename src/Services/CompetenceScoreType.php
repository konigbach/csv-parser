<?php

declare(strict_types=1);

namespace App\Services;

final readonly class CompetenceScoreType implements CompetenceInterface
{
    public function __construct(
        private string $name,
        private ?float $result = null,
    ) {
    }

    public function name(): string
    {
        return $this->name;
    }

    public function result(): float
    {
        return $this->result ?? 0.0;
    }

    public function type(): Type
    {
        return Type::Score;
    }
}
