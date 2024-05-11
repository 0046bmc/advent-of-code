<?php

declare(strict_types=1);

namespace App\Y2020;

use Phaoc\DayBase;
use Phaoc\DayInterface;

class Day01 extends DayBase implements DayInterface
{
    /**
     * @return iterable<string>
     */
    public function testPart1(): iterable
    {
        yield '514579' => $this->getTestInput();
    }

    /**
     * @return iterable<string>
     */
    public function testPart2(): iterable
    {
        yield '241861950' => $this->getTestInput();
    }

    public function solvePart1(string $input): string
    {
        $input = $this->parseInput($input);
        for ($i = 0; $i < count($input); $i++) {
            for ($x = $i; $x < count($input); $x++) {
                if ((intval($input[$i]) + intval($input[$x])) == 2020) {
                    $a = intval($input[$i]);
                    $b = intval($input[$x]);
                    return (string)($a * $b);
                }
            }
        }
        return 'error!';
    }

    public function solvePart2(string $input): string
    {
        $input = $this->parseInput($input);
        for ($i = 0; $i < count($input); $i++) {
            for ($x = $i; $x < count($input); $x++) {
                for ($y = $x; $y < count($input); $y++) {
                    $a = intval($input[$i]);
                    $b = intval($input[$x]);
                    $c = intval($input[$y]);
                    if (($a + $b + $c) == 2020) {
                        $a = intval($input[$i]);
                        $b = intval($input[$x]);
                        $c = intval($input[$y]);
                        return (string)($a * $b * $c);
                    }
                }
            }
        }
        return 'error!';
    }
}
