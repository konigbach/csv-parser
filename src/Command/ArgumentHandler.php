<?php

declare(strict_types=1);

namespace App\Command;

use App\Services\Method;
use App\Services\What;
use Symfony\Component\Console\Input\InputInterface;

final readonly class ArgumentHandler
{
    public function __construct(
        private InputInterface $input
    ) {
    }

    public function what(): What|string
    {
        $what = $this->input->getArgument('what');
        assert(is_string($what), 'Argument must be a string');
        if ('total' === strtolower($what)) {
            return What::Total;
        }

        return $what;
    }

    public function whoHow(): Method|int
    {
        $whoHow = $this->input->getArgument('who/how');
        assert(is_string($whoHow) || is_int($whoHow), 'Argument must be a string or int');

        if (!is_numeric($whoHow)) {
            return Method::from(strtolower($whoHow));
        }

        return (int) $whoHow - 1; // resolves the 0 index for the first user. It could be better.
    }
}
