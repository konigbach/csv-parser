<?php

declare(strict_types=1);

namespace App\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class ScoreParserTest extends KernelTestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testExecute(string $what, int|string $whoHow, string $result): void
    {
        self::bootKernel();
        $application = new Application(self::$kernel);
        $command = $application->find('app:score-parser');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'what' => $what,
            'who/how' => $whoHow,
        ]);

        $commandTester->assertCommandIsSuccessful();
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString($result, $output);
    }

    public function dataProvider(): array
    {
        return [
            'enthousiasm' => ['Enthousiasm', 1, '“Vera Voorbeeld” has a score of 4.8 for Enthousiasm'],
            'total_2' => ['Enthousiasm', 2, '“Donald Duck” has a score of 2.4 for Enthousiasm'],
            'user1_total' => ['total', 1, '“Vera Voorbeeld” has a total score of 4.0'],
            'user2_total' => ['total', 2, '“Donald Duck” has no score for total'],
            'mbolevel_type' => ['MBOLevel', 'type', "The type of MBOLevel is 'level'"],
            'enthousiasm_average' => ['Enthousiasm', 'average', 'The average for Enthousiasm is 3.6'],
        ];
    }

    public function testExceptions(): void
    {
        $this->expectException(\RuntimeException::class);
        self::bootKernel();
        $application = new Application(self::$kernel);
        $command = $application->find('app:score-parser');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'what' => 'MBOLevel',
            'who/how' => 'average',
        ]);

        $commandTester->assertCommandIsSuccessful();
        $output = $commandTester->getDisplay();
    }
}
