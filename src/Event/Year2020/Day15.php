<?php

declare(strict_types=1);

namespace App\Event\Year2020;

use AdventOfCode\DayBase;
use AdventOfCode\DayInterface;
use SplFixedArray;

class Day15 extends DayBase implements DayInterface
{
    public function testPart1(): iterable
    {
        yield '436' => '0,3,6';
        yield '1' => '1,3,2';
        yield '10' => '2,1,3';
        yield '27' => '1,2,3';
        yield '78' => '2,3,1';
        yield '438' => '3,2,1';
        yield '1836' => '3,1,2';
    }

    public function testPart2(): iterable
    {
        yield '175594' => '0,3,6';
//        yield '1' => '1,3,2';
//        yield '10' => '2,1,3';
//        yield '27' => '1,2,3';
//        yield '78' => '2,3,1';
//        yield '438' => '3,2,1';
//        yield '1836' => '3,1,2';
    }

    public function solvePart1(string $input): string
    {
        $input = array_map('intval', explode(',', $input));
        $atNr = 2020;


        $speek = $this->doGame2($input, $atNr);

        return (string)$speek;
    }

    public function solvePart2(string $input): string
    {
        $input = $this->parseInput($input, ',');
        $atNr = 30000000;
        $speek = $this->doGame2($input, $atNr);

        return (string)$speek;
    }

    private function speek($speek, &$spoken, $i, $player, $last)
    {
        $lcount = (isset($spoken[$last])) ? count($spoken[$last]) : 0;
//        echo sprintf("Turn: %4s Last: %4s(%s)  %d says: %s", $i, $last, $lcount, $player, $speek) . PHP_EOL;
        if (!isset($spoken[$speek])) {
            $spoken[$speek] = [$i];
            echo count($spoken) . PHP_EOL;
        } else {
            $spoken[$speek][] = $i;
        }
        if (count($spoken[$speek]) > 2) {
            array_shift($spoken[$speek]);
        }
        return $speek;
    }

    /**
     * @param array $input
     * @param int $atNr
     * @return array
     */
    public function doGame(array $input, int $atNr): array
    {
        $spoken = [];
        $last = '-1';
        $nrOfPlayers = count($input);
        $player = 0;
        $i = 1;
        foreach ($input as $item) {
            $last = $this->speek($input[$i - 1], $spoken, $i, $last, $player);
            $i++;
        }
        for ($i = $i; $i <= $atNr; $i++) {
            if (count($spoken[$last]) == 1) {
                $speek = 0;
            } elseif (count($spoken[$last]) == 2) {
                $speek = $spoken[$last][1] - $spoken[$last][0];
            } else {
                var_dump($spoken);
                exit();
            }
            $last = $this->speek($speek, $spoken, $i, $player, $last);
        }
        return array($spoken, $speek);
    }

    private function speek2($speek, &$spoken, $i, $player, $last)
    {
        if (!isset($spoken[$speek])) {
            $spoken[$speek] = new SplFixedArray(2);
        }
        $spoken[$speek][0] = $spoken[$speek][1];
        $spoken[$speek][1] = $i;
        return $speek;
    }

    /**
     * @param array $input
     * @param int $atNr
     * @return int
     */
    public function doGame2(array $input, int $atNr): int
    {
        $spoken = [];

        foreach ($input as $index => $value) {
            $spoken[$value] = $index + 1;
        }

        $last = $value;

//        unset($spoken[$last]);

        for ($i = count($input); $i < $atNr; $i++) {
            $temp = $last;
            $last = $i - ($spoken[$last] ?? $i);
            $spoken[$temp] = $i;
        }

        return $last;
    }
}
