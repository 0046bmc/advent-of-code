<?php

declare(strict_types=1);

namespace App\Y2020;

use Phaoc\DayBase;
use Phaoc\DayInterface;

class Day10 extends DayBase implements DayInterface
{
    /**
     * @return iterable<string>
     */
    public function testPart1(): iterable
    {
        yield '35' => $this->getTestInput();
        yield '220' => $this->getTestInput(2);
    }

    /**
     * @return iterable<string>
     */
    public function testPart2(): iterable
    {
        yield '8' => $this->getTestInput();
        yield '19208' => $this->getTestInput(2);
    }

    public function solvePart1(string $input): string
    {
        $input = array_map('intval', explode("\n", $input));
        $inv = 0;
        $r = $this->joltCalc($input, $inv);
        $r[3]++;
        return (string)($r[1] * $r[3]);
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
}
