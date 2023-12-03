<?php

declare(strict_types=1);

namespace App\Event\Year2021;

use App\AoC\DayBase;
use App\AoC\DayInterface;
use App\Map2D;
use App\NewMap2D;

class Day11 extends DayBase implements DayInterface
{
    public function testPart1(): iterable
    {
        yield '1656' => '5483143223
2745854711
5264556173
6141336146
6357385478
4167524645
2176841721
6882881134
4846848554
5283751526';
    }

    public function testPart2(): iterable
    {
        yield '195' => '5483143223
2745854711
5264556173
6141336146
6357385478
4167524645
2176841721
6882881134
4846848554
5283751526';
    }

    public function solvePart1(string $input): string
    {
        $O = NewMap2D::createFromString($input);
        $O->defaultGridValue = false;

        $flashcount = 0;

        $flashed = [];
        for ($i = 0; $i < 99; $i++) {
            $this->incEm($O, $flashed);
            $flashed = [];
            $this->flashEm($O, $flashed, $flashcount);
        }

        return (string)$flashcount;
    }

    private function incEm(NewMap2D &$O, array $flashed): void
    {
        foreach ($O->c as $y => $col) {
            foreach ($col as $x => $val) {
                if (!in_array($x . ',' . $y, $flashed)) {
                    $O->setCoord($val + 1, $x, $y);
                }
            }
        }
    }

    private function flashEm(NewMap2D &$O, array &$flashed, int &$flashcount): void
    {
        while ($this->countNines($O) > 0) {
            foreach ($O->c as $y => $col) {
                foreach ($col as $x => $val) {
                    if ($val > 8) {
                        $key = $x . ',' . $y;
                        $flashed[] = $key;
                        $nei = $O->getNeighborCoords($x, $y);
                        foreach ($nei as $n) {
                            $nkey = $n['x'] . ',' . $n['y'];
                            if (!in_array($nkey, $flashed)) {
                                $O->setCoord($n['v'] + 1, $n['x'], $n['y']);
                            }
                        }
                        $O->setCoord(0, $x, $y);
                        $flashcount++;
                    }
                }
            }
        }
    }

    private function countNines(NewMap2D &$O): int
    {
        $return = 0;
        $dd = array_walk_recursive(
            $O->c,
            function ($a) use (&$return) {
                if ($return === 0 && $a > 8) {
                    $return = 1;
                }// = $a>8?true:false;
            }
        );
        return $return;
    }

    public function solvePart2(string $input): string
    {
        $O = NewMap2D::createFromString($input);
        $O->defaultGridValue = false;

        $flashcount = 0;

        $flashed = [];
        for ($i = 2; $i <= 1950000000; $i++) {
            $this->incEm($O, $flashed);
            $flashed = [];
            $this->flashEm($O, $flashed, $flashcount);
            if ($O->nrOf == count($flashed)) {
                break;
            }
        }
        return (string) $i;
    }
}
