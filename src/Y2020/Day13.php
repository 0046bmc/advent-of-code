<?php

declare(strict_types=1);

namespace App\Y2020;

use Phaoc\DayBase;
use Phaoc\DayInterface;

class Day13 extends DayBase implements DayInterface
{
    /**
     * @return iterable<string>
     */
    public function testPart1(): iterable
    {
        yield '295' => '939
7,13,x,x,59,x,31,19';
    }

    /**
     * @return iterable<string>
     */
    public function testPart2(): iterable
    {
        yield '1068781' => '939
7,13,x,x,59,x,31,19';
        yield '3417' => '0
17,x,13,19';
        yield '754018' => '0
67,7,59,61';
        yield '779210' => '0
67,x,7,59,61';
        yield '1261476' => '0
67,7,x,59,61';
        yield '1202161486' => '0
1789,37,47,1889';
    }

    public function solvePart1(string $input): string
    {
        $input = $this->parseInput($input);
        $org_ts = $ts = intval($input[0]);
        $busses = array_unique(explode(',', $input[1]));
        if (($key = array_search('x', $busses)) !== false) {
            unset($busses[$key]);
        }
        $busses = array_values($busses);
        while (true) {
            foreach ($busses as $buss) {
                if (($ts % intval($buss)) == 0) {
                    $ret = intval($buss) * ($ts - $org_ts);
                    return (string)$ret;
                }
            }
            $ts++;
        }
    }

    public function solvePart2(string $input): string
    {
        $input = $this->parseInput($input);
        $busses = explode(',', $input[1]);
        $ts = $this->bussCheck($busses);
        return (string)$ts;
    }

    public function bussCheck(array $busses): int
    {
        //After bruteforce to right result, changed to this
        $busses = array_filter(
            $busses,
            function ($r) {
                return $r !== 'x';
            }
        );
        $busses = array_map('intval', $busses);
        $ts = 0;
        $product = 1;

        foreach ($busses as $add => $buss) {
            while (($ts + $add) % $buss !== 0) {
                $ts += $product;
            }
            $product *= $buss;
        }
        return $ts;
    }
}
