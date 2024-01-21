<?php

declare(strict_types=1);

namespace App\Command;

use App\Services\Search;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:score-parser',
)]
class ScoreParser extends Command
{
    protected function configure(): void
    {
        $this->addArgument(
            'what',
            InputArgument::REQUIRED,
            "Column to calculate. Eg.: 'SomeCompetency' or 'total'"
        )
            ->addArgument(
                'who/how',
                InputArgument::REQUIRED,
                "#Participant to calculate/lowest,highest,average,type. Eg.: '1', 'average', 'type, "
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $argumentHandler = new ArgumentHandler($input);
        $rows = (new CsvParser())->parseCSV();
        $search = new Search(
            what: $argumentHandler->what(),
            whoHow: $argumentHandler->whoHow(),
            rows: $rows,
        );

        $output->writeln([
            'Score Parser',
            '============',
            '',
        ]);

        $output->writeln($search->resolve());

        return Command::SUCCESS;
    }
}
