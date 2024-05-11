<?php

declare(strict_types=1);

namespace App\Y2020;

use Phaoc\DayBase;
use Phaoc\DayInterface;

class Day05 extends DayBase implements DayInterface
{
    private array $seats;
    /**
     * @return iterable<string>
     */
    public function testPart1(): iterable
    {
        yield '567' => 'BFFFBBFRRR';
        yield '119' => 'FFFBBBFRRR';
        yield '820' => 'BBFFBBFRLL';
    }

    /**
     * @return iterable<string>
     */
    public function testPart2(): iterable
    {
        return [];
    }

    public function solvePart1(string $input): string
    {
        $input = $this->parseInput($input);
        $high = -1;
        foreach ($input as $bb) {
            $ins = ['B', 'F', 'R', 'L'];
            $ous = ['1', '0', '1', '0'];
            $bb = str_replace($ins, $ous, $bb);
            $row = (int)base_convert(substr($bb, 0, 7), 2, 10);
            $col = (int)base_convert(substr($bb, 7, 3), 2, 10);
            $nr = $row * 8 + $col;
            $this->seats[$row][$col] = $nr;
            if ($nr > $high) {
                $high = $nr;
            }
        }
        return (string)$high;
    }

    public function solvePart2(string $input): string
    {
        $ret = null;
        ksort($this->seats);
        foreach ($this->seats as $rnr => $c) {
            if (count($c) == 8) {
                continue;
            }
            ksort($c);
            for ($i = 1; $i < 7; $i++) {
                if (
                    !isset($c[$i]) &&
                    isset($c[$i - 1]) &&
                    isset($c[$i + 1])
                ) {
                    $ret = $rnr * 8 + $i;
                }
            }
        }
        return (string)$ret;
    }
}
