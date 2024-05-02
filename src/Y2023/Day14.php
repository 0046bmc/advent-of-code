<?php

declare(strict_types=1);

namespace App\Y2023;

use App\Map2D;
use Phaoc\DayBase;
use Phaoc\DayInterface;

class Day14 extends DayBase implements DayInterface
{
    private array $fixedX;
    private array $fixedY;

    /**
     * @return iterable<string>
     */
    public function testPart1(): iterable
    {
        yield '136' => file_get_contents(__DIR__ . '/Inputs/day14.test1.txt');
    }

    /**
     * @return iterable<string>
     */
    public function testPart2(): iterable
    {
        yield '64' => file_get_contents(__DIR__ . '/Inputs/day14.test1.txt');
        return [];
    }


    public function solvePart1(string $input): string
    {
        $P = Map2D::createFromString($input);
        $P->defaultGridValue = null;

        foreach ($P->c as $y => $xval) {
            foreach ($xval as $x => $value) {
                if ($value === '#') {
                    $this->fixedX[$x][$y] = [$x, $y];
                    $this->fixedY[$y][$x] = [$x, $y];
                }
            }
        }


        $maxX = count($P->c[0]);
        $maxY = count($P->c);

        $this->rollNorth($maxX, $maxY, $P);
        $ret = $this->getRet($P);

        return (string)$ret;
    }

    public function solvePart2(string $input): string
    {
        $P = Map2D::createFromString($input);
        $P->defaultGridValue = null;

        $maxX = count($P->c[0]);
        $maxY = count($P->c);

        foreach (range(0, 1000000 - 1) as $_) {
            if ($_ % 10000 === 0) {
                echo $_ . PHP_EOL;
            }
            $this->rollNorth($maxX, $maxY, $P);
            $this->rollWest($maxX, $maxY, $P);
            $this->rollSouth($maxX, $maxY, $P);
            $this->rollEast($maxX, $maxY, $P);
        }
        $P->print(1);
        $ret = $this->getRet($P);


        return (string)$ret;
    }

    /**
     * @param Map2D $P
     * @return float|int
     */
    public function getRet(Map2D $P): int|float
    {
        $loo = count($P->c);
        $ret = 0;
        foreach ($P->c as $y) {
            $A = array_count_values($y);
            if (isset($A['O'])) {
                $ret += $loo * $A['O'];
            }
            $loo--;
        }
        return $ret;
    }

    /**
     * @param int|null $maxX
     * @param int|null $maxY
     * @param Map2D $P
     * @param bool $print
     * @return void
     */
    public function rollNorth(?int $maxX, ?int $maxY, Map2D $P, bool $print = false): void
    {
        for ($x = 0; $x < $maxX; $x++) {
            for ($y = 0; $y < $maxY; $y++) {
                if (
                    $P->c[$y][$x] != 'O'
                    || !isset($P->c[$y - 1][$x]) || ($P->c[$y][$x] === 'O' && in_array($P->c[$y - 1][$x], ['#', 'O', null]))
                ) {
                    continue;
                }

                $newY = 0;
                if (isset($this->fixedX[$x])) {
                    foreach ($this->fixedX[$x] as [$fx, $fy]) {
                        if (($fy < $y) and $fy >= $newY) {
                            $newY = $fy + 1;
                        }
                    }
                }
                while ($P->c[$newY][$x] === 'O') {
                    ++$newY;
                }
                if ($newY != $y) {
                    $this->move($P, $x, $newY, $x, $y, 'North', $print);
                }
            }
        }
    }

    /**
     * @param int|null $maxX
     * @param int|null $maxY
     * @param Map2D $P
     * @return void
     */
    public function rollWest(?int $maxX, ?int $maxY, Map2D $P, bool $print = false): void
    {
        for ($y = 0; $y < $maxY; $y++) {
            for ($x = 0; $x < $maxX; $x++) {
                if (
                    $P->c[$y][$x] != 'O'
                    || !isset($P->c[$y][$x - 1]) || ($P->c[$y][$x] === 'O' && in_array($P->c[$y][$x - 1], ['#', 'O', null]))
                ) {
                    continue;
                }

                $newX = 0;
                if (isset($this->fixedY[$y])) {
                    foreach ($this->fixedY[$y] as [$fx, $fy]) {
                        if (($fx < $x) and $fx >= $newX) {
                            $newX = $fx + 1;
                        }
                    }
                }
                while ($P->c[$y][$newX] === 'O') {
                    ++$newX;
                }
                if ($newX != $x) {
                    $this->move($P, $newX, $y, $x, $y, 'West', $print);
                }
            }
        }
    }

    /**
     * @param int|null $maxX
     * @param int|null $maxY
     * @param Map2D $P
     * @return void
     */
    public function rollSouth(?int $maxX, ?int $maxY, Map2D $P, bool $print = false): void
    {
        for ($x = 0; $x < $maxX; $x++) {
            for ($y = $maxY - 1; $y >= 0; $y--) {
                if (
                    $P->c[$y][$x] != 'O'
                    || !isset($P->c[$y + 1][$x]) || ($P->c[$y][$x] === 'O' && in_array($P->c[$y + 1][$x], ['#', 'O', null]))
                ) {
                    continue;
                }

                $newY = $maxY - 1;
                if (isset($this->fixedX[$x])) {
                    foreach ($this->fixedX[$x] as [$fx, $fy]) {
                        if (($fy > $y) and $fy <= $newY) {
                            $newY = $fy - 1;
                        }
                    }
                }
                while ($P->c[$newY][$x] === 'O') {
                    --$newY;
                }
                if ($newY != $y) {
                    $this->move($P, $x, $newY, $x, $y, 'South', $print);
                }
            }
        }
    }

    /**
     * @param int|null $maxX
     * @param int|null $maxY
     * @param Map2D $P
     * @return void
     */
    public function rollEast(?int $maxX, ?int $maxY, Map2D $P, bool $print = false): void
    {
        for ($y = 0; $y < $maxY; $y++) {
            for ($x = $maxX - 1; $x >= 0; $x--) {
                if (
                    $P->c[$y][$x] != 'O'
                    || !isset($P->c[$y][$x + 1]) || ($P->c[$y][$x] === 'O' && in_array($P->c[$y][$x + 1], ['#', 'O', null]))
                ) {
                    continue;
                }

                $newX = $maxX - 1;
                if (isset($this->fixedY[$y])) {
                    foreach ($this->fixedY[$y] as [$fx, $fy]) {
                        if (($fx > $x) and $fx <= $newX) {
                            $newX = $fx - 1;
                        }
                    }
                }
                while ($P->c[$y][$newX] === 'O') {
                    --$newX;
                }
                if ($newX != $x) {
                    $this->move($P, $newX, $y, $x, $y, 'East', $print);
                }
            }
        }
    }

    private function clear(): void
    {
        echo chr(27) . chr(91) . 'H' . chr(27) . chr(91) . 'J';
    }

    /**
     * @param Map2D $P
     * @param int $xx
     * @param int $yy
     * @param int $x
     * @param int $y
     * @param string $dir
     * @param bool $print
     * @return void
     */
    public function move(Map2D $P, int $xx, int $yy, int $x, int $y, string $dir, $print = false): void
    {
        if ($print) {
            $P->setCoord("\033[35mO\033[0m", $x, $y);
            $this->clear();
            echo 'Moving ' . $dir . ' From :' . " $x,$y => $xx,$yy" . PHP_EOL;
            $P->print(0);
            usleep(2000000);
            $P->setCoord("\033[32mO\033[0m", $xx, $yy);
            $P->setCoord("\033[32mX\033[0m", $x, $y);
            $this->clear();
            echo 'Moving ' . $dir . ' From :' . " $x,$y => $xx,$yy" . PHP_EOL;
            $P->print(0);
            usleep(2000000);
        }
        $P->setCoord('O', $xx, $yy);
        $P->setCoord('.', $x, $y);
    }

}