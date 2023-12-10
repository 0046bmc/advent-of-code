<?php

declare(strict_types=1);

namespace App\Y2021;

use Phaoc\DayBase;
use Phaoc\DayInterface;

class Day02 extends DayBase implements DayInterface
{
    public function testPart1(): iterable
    {
        yield '150' => 'forward 5
down 5
forward 8
up 3
down 8
forward 2';
    }

    public function testPart2(): iterable
    {
        yield '900' => 'forward 5
down 5
forward 8
up 3
down 8
forward 2';
    }

    public function solvePart1(string $input): string
    {
        $y = 0;
        $x = 0;
        $input = $this->parseInput($input);
        foreach ($input as $row) {
            preg_match('/(forward|up|down) (\d+)/', $row, $ar);
            print_r($ar);
            if ($ar[1] == 'forward') {
                $y += $ar[2];
            }
            if ($ar[1] == 'down') {
                $x += $ar[2];
            }
            if ($ar[1] == 'up') {
                $x -= $ar[2];
            }
        }
        echo 'F: ' . $y . PHP_EOL;
        echo 'D: ' . $x . PHP_EOL;
        return strval($y * $x);
    }

    public function solvePart2(string $input): string
    {
        $y = 0;
        $x = 0;
        $aim = 0;
        $input = $this->parseInput($input);
        foreach ($input as $row) {
            preg_match('/(forward|up|down) (\d+)/', $row, $ar);
            print_r($ar);
            if ($ar[1] == 'forward') {
                $y += $ar[2];
                $x += $ar[2] * $aim;
            }
            if ($ar[1] == 'down') {
                $aim += $ar[2];
            }
            if ($ar[1] == 'up') {
                $aim -= $ar[2];
            }
        }
        echo 'F: ' . $y . PHP_EOL;
        echo 'D: ' . $x . PHP_EOL;
        return strval($y * $x);
    }
}
