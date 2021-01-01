<?php

declare(strict_types=1);

namespace App\Event\Year2020;

use AdventOfCode\DayBase;
use AdventOfCode\DayInterface;

//ini_set('memory_limit', (4095).'M');

class Day10 extends DayBase implements DayInterface
{
    private string $t1 = '16
10
15
5
1
11
7
19
6
12
4';
    private string $t2 = '28
33
18
42
31
14
46
20
48
47
24
23
49
45
19
38
39
11
1
32
25
35
8
17
7
9
4
2
34
10
3';

    public function testPart1(): iterable
    {
        yield '35' => $this->t1;
        yield '220' => $this->t2;
    }

    public function testPart2(): iterable
    {
        yield '8' => $this->t1;
        yield '19208' => $this->t2;
    }

    public function solvePart1(string $input): string
    {
        $input = array_map('intval', explode("\n", $input));
        $inv = 0;
        $r = $this->joltCalc($input, $inv);
        $r[3]++;
        return (string)($r[1] * $r[3]);
    }

    /**
     * @param array $input
     * @param int $inv
     */
    public function joltCalc(array $input, int $inv, $inst = [1 => 0, 3 => 0]): array
    {
        if (($key = array_search($inv + 1, $input)) !== false) {
            $inst[1] += 1;
        } elseif (($key = array_search($inv + 3, $input)) !== false) {
            $inst[3] += 1;
        } else {
            return $inst;
        }
        $b = $input;
        $nin = array_splice($b, $key, 1);

        $inst = $this->joltCalc($b, intval($nin[0]), $inst);
        return $inst;
    }

    public function solvePart2(string $input): string
    {
        $inputz = array_map('intval', explode("\n", $input));
        $inputz[] = 0;
        sort($inputz);
        $cal = array_fill(0, end($inputz) + 4, 0);
        $cal[0] = 1;
        $inputz[] = end($inputz) + 3;
        foreach ($inputz as $i) {
            $res = array_intersect($inputz, [$i + 1, $i + 2, $i + 3]);
            foreach ($res as $nr) {
                $cal[$nr] += $cal[$i];
            }
        }
        return (string)end($cal);
    }
}
