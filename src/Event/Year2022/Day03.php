<?php

declare(strict_types=1);

namespace App\Event\Year2022;

use mahlstrom\AoC\DayBase;
use mahlstrom\AoC\DayInterface;

class Day03 extends DayBase implements DayInterface
{
    public function testPart1(): iterable
    {
        yield '157' => file_get_contents(__DIR__ . '/TestInputs/Day03.1.txt');
    }

    public function testPart2(): iterable
    {
        yield '70' => file_get_contents(__DIR__ . '/TestInputs/Day03.1.txt');
    }

    public function solvePart1(string $input): string
    {
        $input = $this->parseInput($input);
        $sum = 0;
        foreach ($input as $item) {
            list($comp1, $comp2) = array_chunk(str_split($item), strlen($item) / 2);
#            echo join('',$comp1).' '.join('',$comp2).PHP_EOL;
            $diff = array_intersect($comp1, $comp2);
            $sum += $this->getPrioFromIntersect($diff);
        }
        return (string)$sum;
    }

    public function solvePart2(string $input): string
    {
        $input = $this->parseInput($input);

        $tot = 0;
        for ($i = 0; $i < count($input); $i += 3) {
            $r1 = str_split($input[$i]);
            $r2 = str_split($input[$i + 1]);
            $r3 = str_split($input[$i + 2]);
            $diff = array_intersect($r1, $r2, $r3);
            $tot+=$this->getPrioFromIntersect($diff);
        }
        return (string)$tot;
    }

    private function getPrioFromIntersect($diff)
    {
        $char = array_pop($diff);
        if (ord($char) > 90) {
            $prio = ord($char) - 96;
        } else {
            $prio = ord($char) - 38;
        }
        return $prio;
    }
}
