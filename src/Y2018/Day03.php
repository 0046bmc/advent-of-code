<?php

declare(strict_types=1);

namespace App\Y2018;

use Phaoc\DayBase;
use Phaoc\DayInterface;

class Day03 extends DayBase implements DayInterface
{
    private string $pattern = '/^#(?<id>\d+) @ (?<y>\d+),(?<x>\d+): (?<w>\d+)x(?<h>\d+)$/';
    private array $names = ['id' => null, 'x' => null, 'y' => null, 'h' => null, 'w' => null];

    public function testPart1(): iterable
    {
        yield '4' => '#1 @ 1,3: 4x4
#2 @ 3,1: 4x4
#3 @ 5,5: 2x2';
    }

    public function testPart2(): iterable
    {
        yield '3' => '#1 @ 1,3: 4x4
#2 @ 3,1: 4x4
#3 @ 5,5: 2x2';
    }

    public function solvePart1(string $input): string
    {
        $input = $this->parseInput($input);
        $map = [];
        foreach ($input as $line) {
            preg_match($this->pattern, $line, $parts);

            for ($x = $parts[2]; $x < $parts[2] + $parts[4]; $x++) {
                for ($y = $parts[3]; $y < $parts[3] + $parts[5]; $y++) {
                    $map[$x . '.' . $y] = isset($map[$x . '.' . $y]) ? 2 : 1;
                }
            }
        }
        return (string)array_count_values($map)[2];
    }

    public function solvePart2(string $input): string
    {
        $input = $this->parseInput($input);
        $map = [];
        foreach ($input as $line) {
            preg_match($this->pattern, $line, $parts);

            for ($x = $parts[2]; $x < $parts[2] + $parts[4]; $x++) {
                for ($y = $parts[3]; $y < $parts[3] + $parts[5]; $y++) {
                    $map[$x . '.' . $y] = isset($map[$x . '.' . $y]) ? 'X' : $parts[1];
                }
            }
        }
        foreach ($input as $line) {
            $crash = false;
            preg_match($this->pattern, $line, $parts);
            for ($x = $parts[2]; $x < $parts[2] + $parts[4]; $x++) {
                for ($y = $parts[3]; $y < $parts[3] + $parts[5]; $y++) {
                    if ($map[$x . '.' . $y] != $parts[1]) {
                        $crash = true;
                        continue 2;
                    }
                }
            }
            if ($crash === false) {
                return (string)$parts[1];
            }
        }

        return '';
    }
}
