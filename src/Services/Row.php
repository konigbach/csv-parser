<?php

declare(strict_types=1);

namespace App\Services;

final readonly class Row
{
    /**
     * @param \App\Services\CompetenceInterface[] $competences
     */
    public function __construct(
        public string $name,
        public array $competences = [],
        public ?string $total = null,
    ) {
    }

    public function searchByCompetenceName(string $competanceName): CompetenceInterface|null
    {
        foreach ($this->competences as $competence) {
            if ($competence->name() === $competanceName) {
                return $competence;
            }
        }

        return null;
    }
}
