<?php

declare(strict_types=1);

namespace App\Services;

final readonly class Rows
{
    /**
     * @param array<Row> $rows
     */
    public function __construct(
        private array $rows,
    ) {
    }

    public function searchByParticipantId(int $participantId): Row
    {
        if (!isset($this->rows[$participantId])) {
            throw new \RuntimeException('Participant not found.');
        }

        return $this->rows[$participantId];
    }

    public function average(string $name): float|null
    {
        $total = 0;
        foreach ($this->rows as $row) {
            $competence = $row->searchByCompetenceName($name);
            if (!$competence instanceof CompetenceScoreType) {
                throw new \RuntimeException('Competence is not scorable.');
            }
            $total += $competence->result();
        }

        return $total / count($this->rows);
    }

    public function lowest(string $name): float|null
    {
        $lowest = null;
        foreach ($this->rows as $row) {
            $competence = $row->searchByCompetenceName($name);
            if (!$competence instanceof CompetenceScoreType) {
                throw new \RuntimeException('Competence is not scorable.');
            }
            if (null === $lowest || $competence->result() < $lowest) {
                $lowest = $competence->result();
            }
        }

        return $lowest;
    }

    public function highest(string $name): float|null
    {
        $highest = null;
        foreach ($this->rows as $row) {
            $competence = $row->searchByCompetenceName($name);
            if (!$competence instanceof CompetenceScoreType) {
                throw new \RuntimeException('Competence is not scorable.');
            }
            if (null === $highest || $competence->result() > $highest) {
                $highest = $competence->result();
            }
        }

        return $highest;
    }
}
