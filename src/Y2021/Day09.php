<?php

declare(strict_types=1);

namespace App\Y2021;

use Phaoc\DayBase;
use Phaoc\DayInterface;
use App\Map2D;

class Day09 extends DayBase implements DayInterface
{
    private array $checked;

    public function testPart1(): iterable
    {
        yield '15' => '2199943210
3987894921
9856789892
8767896789
9899965678';
    }

    public function testPart2(): iterable
    {
        yield '1134' => '2199943210
3987894921
9856789892
8767896789
9899965678';
    }

    public function solvePart1(string $input): string
    {
        $m = Map2D::createFromString($input);
        $m->defaultGridValue = false;

        $res = 0;
        foreach ($m->c as $y => $xd) {
            foreach ($xd as $x => $v) {
                $isLow = $m->isLowestInNeighborhood($x, $y);
                if ($isLow) {
                    $res += (intval($m->getCoord($x, $y)) + 1);
                }
            }
        }
        return (string)$res;
    }

    public function solvePart2(string $input): string
    {
        $m = Map2D::createFromString($input);
        $m->defaultGridValue = false;
        $basins = $this->checked = [];

        foreach ($m->c as $y => $yd) {
            foreach ($yd as $x => $value) {
                if (in_array($x . ',' . $y, $this->checked) || $value > 8) {
                    continue;
                }
                $basins[$x . ',' . $y] = $this->basinSize($m, $x, $y);
            }
        }
        rsort($basins);
        return (string) array_product(array_slice($basins, 0, 3));
    }

    public function basinSize(Map2D &$m, int $x, int $y): int
    {
        $size = 1;
        $this->checked[] = $x . ',' . $y;
            $choords = $m->getNeighborCoordsUDLR($x, $y);
        foreach ($choords as $choord) {
            if (in_array($choord['x'] . ',' . $choord['y'], $this->checked) || $choord['v'] == "9") {
                continue;
            }
            $size += $this->basinSize($m, $choord['x'], $choord['y']);
        }
        return $size;
    }
}
