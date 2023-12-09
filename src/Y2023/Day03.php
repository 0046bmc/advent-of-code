<?php

declare(strict_types=1);

namespace App\Y2023;

use Phaoc\DayBase;
use Phaoc\DayInterface;
use App\Map2D;

class Day03 extends DayBase implements DayInterface
{
    /**
     * @return iterable<string>
     */
    public function testPart1(): iterable
    {

        yield '4361' => file_get_contents(__DIR__ . '/Inputs/day03.test1.txt');
    }

    /**
     * @return iterable<string>
     */
    public function testPart2(): iterable
    {
        yield '467835' => file_get_contents(__DIR__ . '/Inputs/day03.test1.txt');
    }

    public function solvePart1(string $input): string
    {
        $map = Map2D::createFromString($input);
        $map->defaultGridValue = null;
        $numbers = ['checked' => []];
        foreach ($map->c as $y => $xval) {
            foreach ($xval as $x => $v) {
                $startPos = $x . '-' . $y;
                if (isset($numbers['checked'][$startPos])) {
                    continue;
                }
                if (is_numeric($v)) {
                    $isAdjacent = false;
                    $theNumber = $v;
                    foreach ($map->getNeighborCoords($x, $y) as $ccc) {
                        if (
                            !is_numeric($ccc['v']) &&
                            $ccc['v'] != '.'
                        ) {
                            $isAdjacent = true;
                        }
                    }
                    $numbers['checked'][$x . '-' . $y] = true;
                    $nextX = $x + 1;
                    $nextY = $y;
                    $next = $map->getCoord($nextX, $nextY);
                    while (is_numeric($next)) {
                        $theNumber .= $next;
                        foreach ($map->getNeighborCoords($nextX, $nextY) as $ccc) {
                            if (!is_numeric($ccc['v']) && $ccc['v'] != '.') {
                                $isAdjacent = true;
                            }
                        }
                        $nextPos = $nextX . '-' . $nextY;
                        $numbers['checked'][$nextPos] = true;

                        $nextX++;
                        $next = $map->getCoord($nextX, $nextY);
                    }
                    if ($isAdjacent) {
                        $numbers[] = $theNumber;
                    }
                }
            }
        }

        unset($numbers['checked']);
        return (string)array_sum($numbers);
    }

    public function solvePart2(string $input): string
    {
        $map = Map2D::createFromString($input);
        $map->defaultGridValue = null;
        $ret = 0;
        foreach ($map->c as $y => $xval) {
            foreach ($xval as $x => $v) {
                if ($v === '*') {
                    $nrs = [];
                    $data = $map->getNeighborCoordsWithKey($x, $y);
                    $skip = [];
                    foreach ($data as $coordKey => $coord) {
                        if (in_array($coordKey, $skip)) {
                            continue;
                        }
                        if (is_numeric($coord['v'])) {
                            list($nr, $filled) = $map->getFullNumber($coord['x'], $coord['y']);
                            $skip = array_merge($skip, $filled);
                            $nrs[] = $nr;
                        }
                    }
                    if (count($nrs) == 2) {
                        $ret += array_product($nrs);
                    }
                }
            }
        }
        return (string)$ret;
    }
}
