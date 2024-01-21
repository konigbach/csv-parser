<?php

namespace App\Services;

interface CompetenceInterface
{
    public function name(): string;

    public function result(): string|float|int|null;

    public function type(): Type;
}
