<?php

declare(strict_types=1);

namespace App\Y2020;

use Phaoc\DayBase;
use Phaoc\DayInterface;
use App\Y2020\Helpers\ACC;

class Day08 extends DayBase implements DayInterface
{
    /**
     * @return iterable<string>
     */
    public function testPart1(): iterable
    {
        yield '5' => $this->getTestInput();
    }

    /**
     * @return iterable<string>
     */
    public function testPart2(): iterable
    {
        yield '8' => $this->getTestInput(2);
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
