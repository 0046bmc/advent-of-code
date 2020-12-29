<?php

declare(strict_types=1);

namespace App\Event\Year2020;

use AdventOfCode\DayBase;
use AdventOfCode\DayInterface;

class Day11 extends DayBase implements DayInterface
{
    public function testPart1(): iterable
    {
        yield '37' => 'L.LL.LL.LL
LLLLLLL.LL
L.L.L..L..
LLLL.LL.LL
L.LL.LL.LL
L.LLLLL.LL
..L.L.....
LLLLLLLLLL
L.LLLLLL.L
L.LLLLL.LL';
    }

    public function testPart2(): iterable
    {
        yield '26' => 'L.LL.LL.LL
LLLLLLL.LL
L.L.L..L..
LLLL.LL.LL
L.LL.LL.LL
L.LLLLL.LL
..L.L.....
LLLLLLLLLL
L.LLLLLL.L
L.LLLLL.LL';
    }

    public function solvePart1(string $input): string
    {
        $curr = array_map('str_split', explode("\n", chop($input)));
        $last = $curr;
        while (true) {
            $curr = $this->populateSeats($curr);
            if ($curr == $last) {
                return (string)$this->countOccupied($curr);
            }
            $last = $curr;
        }
    }

    private function populateSeats(array $curr, $mbs = false)
    {
        $ret = $curr;
        foreach ($curr as $r => $line) {
            foreach ($line as $c => $v) {
                $adj = $this->getAdjacentChairs($r, $c, $curr, $mbs);
                switch ($v) {
                    case 'L':
                        if ($this->sitDown($adj, $curr)) {
                            $ret[$r][$c] = '#';
                        }
                        break;
                    case '#':
                        if ($this->leaveSeat($adj, $curr, ($mbs) ? 5 : 4)) {
                            $ret[$r][$c] = 'L';
                        }
                }
            }
        }
        return $ret;
    }

    private function getAdjacentChairs($r, $c, $cur, $mbs)
    {
        $ret = [];
        for ($x = -1; $x <= 1; $x++) {
            for ($y = -1; $y <= 1; $y++) {
                if ($y == 0 && $x == 0) {
                    continue;
                }
                $found = true;
                $tx = ($r + $x);
                $ty = ($c + $y);
                if (!isset($cur[$tx]) || !isset($cur[$tx][$ty])) {
                    continue;
                }

                if ($mbs) {
                    $n = 2;
                    while ($cur[$tx][$ty] == '.') {
                        $tx = ($r + ($x * $n));
                        $ty = ($c + ($y * $n));
                        $n++;
                        if (!isset($cur[$tx]) || !isset($cur[$tx][$ty])) {
                            $found = false;
                            break;
                        }
                    }
                }
                if ($found) {
                    $ret[] = [$tx, $ty];
                }
            }
        }
        return $ret;
    }

    private function sitDown($adj, array $cur): bool
    {
        foreach ($adj as $v) {
            if ($cur[$v[0]][$v[1]] == '#') {
                return false;
            }
        }
        return true;
    }

    private function leaveSeat($adj, array $curr, $tolerance): bool
    {
        $occ = 0;
        foreach ($adj as $v) {
            if ($curr[$v[0]][$v[1]] == '#') {
                $occ++;
                if ($occ >= $tolerance) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @param array $curr
     * @return int|mixed
     */
    private function countOccupied(array $curr)
    {
        $occ = 0;
        foreach ($curr as $row) {
            $f = array_count_values($row);
            $occ += (isset($f['#'])) ? $f['#'] : 0;
        }
        return $occ;
    }

    public function solvePart2(string $input): string
    {
        $curr = array_map('str_split', explode("\n", chop($input)));
        $last = $curr;
        while (true) {
            $curr = $this->populateSeats($curr, true);
            if ($curr == $last) {
                return (string)$this->countOccupied($curr);
            }
            $last = $curr;
        }
    }
}
