<?php

declare(strict_types=1);

namespace App\Services;

final readonly class CompetenceLevelType implements CompetenceInterface
{
    public function __construct(
        private string $name,
        private ?string $result = null,
    ) {
    }

    public function name(): string
    {
        return $this->name;
    }

    public function result(): ?string
    {
        return $this->result;
    }

    public function type(): Type
    {
        return Type::Level;
    }
}
