<?php

declare(strict_types=1);

namespace App\Command;

use App\Services\CompetenceFactory;
use App\Services\Row;
use App\Services\Rows;
use Symfony\Component\Finder\Finder;

class CsvParser
{
    /**
     * @var array{finder_in: string, finder_name: string, ignoreFirstLine: bool}
     */
    private array $csvParsingOptions = [
        'finder_in' => __DIR__.'/../../tests/Command/documents',
        'finder_name' => 'first_example.csv',
        'ignoreFirstLine' => true,
    ];

    public function parseCSV(): Rows
    {
        $ignoreFirstLine = $this->csvParsingOptions['ignoreFirstLine'];

        $finder = new Finder();
        $finder->files()
            ->in($this->csvParsingOptions['finder_in'])
            ->name($this->csvParsingOptions['finder_name']);

        $csv = null;
        foreach ($finder as $file) {
            $csv = $file;
        }
        assert($csv instanceof \SplFileInfo);
        $rows = [];
        if (($handle = fopen($csv->getRealPath(), 'rb')) === false) {
            throw new \RuntimeException('Error opening file');
        }

        $i = 0;
        $totalKey = 0;
        $competences = [];
        $competenceNames = [];

        while (($data = fgetcsv($handle, null, ';')) !== false) {
            ++$i;
            if ($ignoreFirstLine && 1 === $i) {
                $totalKey = array_search('Total', $data, true);
                assert(false !== $totalKey, 'Total column not found');
                assert($totalKey > 1, 'Total column must be after first column');
                assert($totalKey === count($data) - 1, 'Total column must be the last column');
                $competenceNames = array_slice($data, 1, $totalKey);
                continue;
            }

            for ($j = 1; $j < $totalKey; ++$j) {
                $competences[] = CompetenceFactory::build(
                    name: $competenceNames[$j - 1],
                    result: $data[$j]
                );
            }

            $rows[] = new Row(
                name: $data[0],
                competences: $competences,
                total: $data[$totalKey],
            );
            $competences = [];
        }
        fclose($handle);

        return new Rows($rows);
    }
}
