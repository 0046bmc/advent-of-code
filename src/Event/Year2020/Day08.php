<?php

declare(strict_types=1);

namespace App\Event\Year2020;

use AdventOfCode\DayBase;
use AdventOfCode\DayInterface;
use App\Event\Year2020\Helpers\ACC;
use App\Event\Year2020\Helpers\ACC2;

class Day08 extends DayBase implements DayInterface
{
    public function testPart1(): iterable
    {
        yield '5' => 'nop +0
acc +1
jmp +4
acc +3
jmp -3
acc -99
acc +1
jmp -4
acc +6';
    }

    public function testPart2(): iterable
    {
        yield '8' => 'nop +0
acc +1
jmp +4
acc +3
jmp -3
acc -99
acc +1
jmp -4
acc +6';
    }

    public function solvePart1(string $input): string
    {
        $input = $this->parseInput($input);

        $ACC = new ACC($input);
        $ACC->run();

        return (string)$ACC->acc;
    }

    public function solvePart2(string $input): string
    {
        $input = $this->parseInput($input);

        $testPos = 1;
        do {
            $nojmp = 0;
            $tInput = $input;
            $from = $to = null;
            for ($i = 0; $i < count($input); $i++) {
                if (substr($input[$i], 0, 3) == 'jmp') {
                    $nojmp++;
                    $from = 'jmp';
                    $to = 'nop';
                } elseif (substr($input[$i], 0, 3) == 'nop') {
                    $nojmp++;
                    $from = 'nop';
                    $to = 'jmp';
                }
                if ($nojmp == $testPos) {
                    $tInput[$i] = str_replace($from, $to, $input[$i]);
                    break;
                }
            }
            $ACC = new ACC($tInput);
            $testPos++;
        } while (!$ACC->run());
        return (string)$ACC->acc;
    }
}
