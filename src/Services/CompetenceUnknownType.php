<?php

declare(strict_types=1);

namespace App\Services;

final readonly class CompetenceUnknownType implements CompetenceInterface
{
    public function __construct(
        private string $name,
        private null $result,
    ) {
    }

    public function name(): string
    {
        return $this->name;
    }

    public function result(): null
    {
        return $this->result;
    }

    public function type(): Type
    {
        return Type::Unknown;
    }
}
