<?php

declare(strict_types=1);

namespace App\Services;

final readonly class Search
{
    public function __construct(
        public What|string $what,
        public Method|int $whoHow,
        public Rows $rows,
    ) {
    }

    public function resolve(): string
    {
        if (What::Total === $this->what && is_int($this->whoHow)) {
            $row = $this->rows->searchByParticipantId($this->whoHow);
            if (!$row->total) {
                return "{$row->name} has no score for total";
            }

            return "{$row->name} has a total score of {$row->total}";
        }

        if (is_string($this->what) && is_int($this->whoHow)) {
            $row = $this->rows->searchByParticipantId($this->whoHow);
            if ($row->searchByCompetenceName($this->what)) {
                $response = "{$row->name} has a score of {$row->searchByCompetenceName($this->what)->result()} for {$this->what}";
            } else {
                $response = "{$row->name} has no score for {$this->what}";
            }
        }

        if (Method::Lowest === $this->whoHow && is_string($this->what)) {
            $lowest = $this->rows->lowest($this->what);
            if (!$lowest) {
                $response = "No lowest for {$this->what}";
            } else {
                $response = "The lowest for {$this->what} is {$lowest}";
            }
        }

        if (Method::Highest === $this->whoHow && is_string($this->what)) {
            $highest = $this->rows->highest($this->what);
            if (!$highest) {
                $response = "No highest for {$this->what}";
            } else {
                $response = "The highest for {$this->what} is {$highest}";
            }
        }

        if (Method::Average === $this->whoHow && is_string($this->what)) {
            $average = $this->rows->average($this->what);

            if (!$average) {
                $response = "No average for {$this->what}";
            } else {
                $response = "The average for {$this->what} is {$average}";
            }
        }

        if (Method::Type === $this->whoHow && is_string($this->what)) {
            $row = $this->rows->searchByParticipantId(0);
            $competence = $row->searchByCompetenceName($this->what);

            if ($competence) {
                $response = "The type of {$this->what} is '{$competence->type()->value}'";
            } else {
                $response = "The type of {$this->what} is not found";
            }
        }

        return $response ?? 'not found';
    }
}
