<?php

declare(strict_types=1);

namespace App\Y2020;

use Phaoc\DayBase;
use Phaoc\DayInterface;

class Day06 extends DayBase implements DayInterface
{
    /**
     * @return iterable<string>
     */
    public function testPart1(): iterable
    {
        yield '11' => file_get_contents(__DIR__ . '/Inputs/day06.test1.txt');
    }

    /**
     * @return iterable<string>
     */
    public function testPart2(): iterable
    {
        yield '6' => file_get_contents(__DIR__ . '/Inputs/day06.test1.txt');
    }

    public function solvePart1(string $input): string
    {
        $input = $this->parseInput($input);
        $ret = 0;
        $all = [];
        $g = 0;
        $b = [];
        foreach ($input as $r) {
            if ($r == '') {
                $all[$g] = $b;
                $g++;
                $b = [];
                continue;
            }
            $o = str_split($r);
            foreach ($o as $a) {
                $b[$a] = true;
            }
        }
        $all[$g] = $b;
        foreach ($all as $g) {
            $ret += count($g);
        }
        return (string)$ret;
    }

    public function solvePart2(string $input): string
    {
        $input = $this->parseInput($input);
        $ret = 0;
        $all = [];
        $gc = [];
        $g = 0;
        $b = [];
        $n = 0;
        foreach ($input as $r) {
            if ($r == '') {
                $all[$g] = $b;
                $gc[$g] = $n;
                $g++;
                $b = [];
                $n = 0;
                continue;
            }

            $o = str_split($r);
            foreach ($o as $a) {
                if (!isset($b[$a])) {
                    $b[$a] = 0;
                }
                $b[$a] += 1;
            }
            $n++;
        }
        $all[$g] = $b;
        $gc[$g] = $n;
        foreach ($gc as $gid => $pp) {
            $dd = array_count_values($all[$gid]);
            $ret += (!empty($dd[$pp])) ? $dd[$pp] : 0;
        }
        return (string)$ret;
    }
}
