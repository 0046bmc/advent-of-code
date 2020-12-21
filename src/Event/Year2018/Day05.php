<?php

declare(strict_types=1);

namespace App\Event\Year2018;

use AdventOfCode\DayBase;
use AdventOfCode\DayInterface;

ini_set('memory_limit', '2048M');

class Day05 extends DayBase implements DayInterface
{
    public function testPart1(): iterable
    {
        yield '10' => 'dabAcCaCBAcCcaDA';
    }

    public function testPart2(): iterable
    {
        yield '4' => 'dabAcCaCBAcCcaDA';
    }

    public function solvePart1(string $input): string
    {

        $input = chop($input);
        $input = $this->poly($input);
        return (string)strlen($input);
    }

    public function solvePart2(string $input): string
    {
        $input = chop($input);
        $chars = array_unique(str_split(strtolower($input)));
        sort($chars);
        $low = PHP_INT_MAX;
        foreach ($chars as $c) {
            $pat = '/' . $c . '/i';
            $r = preg_replace($pat, '', $input);
            $r = $this->poly($r);
            if (strlen($r) < $low) {
                $low = strlen($r);
            }
        }

        return (string)$low;
    }

    /**
     * @param string $input
     * @return string
     */
    public function poly(string $input): string
    {
        $loop = true;
        $ii = 0;
        while ($loop == true) {
            $loop = false;
            for ($i = $ii; $i < strlen($input) - 1; $i++) {
                if (strtolower($input[$i]) == strtolower($input[$i + 1]) && $input[$i] != $input[$i + 1]) {
                    $input = substr($input, 0, $i) . substr($input, $i + 2);
                    $i--;
                    $loop = true;
                }
            }
        }
        return $input;
    }
}
