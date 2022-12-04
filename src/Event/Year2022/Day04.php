<?php

declare(strict_types=1);

namespace App\Event\Year2022;

use mahlstrom\AoC\DayBase;
use mahlstrom\AoC\DayInterface;

class Day04 extends DayBase implements DayInterface
{
    public function testPart1(): iterable
    {
        yield '2' => file_get_contents(__DIR__ . '/TestInputs/Day04.1.txt');
    }

    public function testPart2(): iterable
    {
        yield '4' => file_get_contents(__DIR__ . '/TestInputs/Day04.1.txt');

    }

    public function solvePart1(string $input): string
    {
        $input = $this->parseInput($input);
        $fully = 0;
        foreach ($input as $pair) {
            list($sec1, $sec2) = explode(',', $pair);
            $sec1 = explode('-', $sec1);
            $sec2 = explode('-', $sec2);
            if (
                ($sec1[0] <= $sec2[0] && $sec1[1] >= $sec2[1]) ||
                ($sec2[0] <= $sec1[0] && $sec2[1] >= $sec1[1])
            ) {
                $fully++;
            }
        }
        return (string)$fully;
    }

    public function solvePart2(string $input): string
    {
        $input = $this->parseInput($input);
        $fully = 0;
        foreach ($input as $pair) {
            list($sec1, $sec2) = explode(',', $pair);
            $sec1 = explode('-', $sec1);
            $sec2 = explode('-', $sec2);
            $sec1=range($sec1[0],$sec1[1]);
            $sec2=range($sec2[0],$sec2[1]);
            foreach($sec2 as $nr){
                if(in_array($nr,$sec1)){
                    $fully+=1;
                    break;
                }
            }

        }
        return (string)$fully;
    }
}
