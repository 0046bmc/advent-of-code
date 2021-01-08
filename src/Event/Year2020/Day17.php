<?php

declare(strict_types=1);

namespace App\Event\Year2020;

use AdventOfCode\DayBase;
use AdventOfCode\DayInterface;
use mahlstrom\D3Array;
use mahlstrom\D4Array;

class Day17 extends DayBase implements DayInterface
{
    public function testPart1(): iterable
    {
        yield '112' => '.#.
..#
###';
    }

    public function testPart2(): iterable
    {
        yield '848' => '.#.
..#
###';
    }

    public function solvePart1(string $input): string
    {
        $c[0] = array_map('str_split', explode("\n", chop($input)));
        $X = new D3Array($c);
        $Xnew = clone $X;
        $i = 0;
//        $Xnew->print($i);
        while ($i < 6) {
            for ($y = $X->minMax['y'][0] - 1; $y <= $X->minMax['y'][1] + 1; $y++) {
                for ($z = $X->minMax['z'][0] - 1; $z <= $X->minMax['z'][1] + 1; $z++) {
                    for ($x = $X->minMax['x'][0] - 1; $x <= $X->minMax['x'][1] + 1; $x++) {
                        $res = $X->getNeighborCoords($x, $y, $z);
                        if (isset($X->c[$z][$y][$x]) && !in_array(count($res), [2, 3])) {
                            unset($Xnew->c[$z][$y][$x]);
                        } elseif (!isset($X->c[$z][$y][$x]) && count($res) == 3) {
                            $Xnew->c[$z][$y][$x] = '#';
                            $Xnew->checkMinMax('x', $x, $x);
                            $Xnew->checkMinMax('y', $y, $y);
                            $Xnew->checkMinMax('z', $z, $z);
                        }
                    }
                }
            }
//            echo PHP_EOL;
            $i++;
            $Xnew->cleanUp();
//            if ($i <= 3) {
//                $Xnew->print($i);
//            }
            $X = clone $Xnew;
        }
        $tot = 0;
        foreach ($X->c as $y) {
            foreach ($y as $x) {
                $tot += count($x);
            }
        }

        return (string)$tot;
    }

    public function solvePart2(string $input): string
    {
        $c[0] = [0 => array_map('str_split', explode("\n", chop($input)))];
        $X = new D4Array($c);
        $Xnew = clone $X;
        $i = 0;
//        $Xnew->print($i);

        while ($i < 6) {
            for ($w = $X->minMax['w'][0] - 1; $w <= $X->minMax['w'][1] + 1; $w++) {
                for ($y = $X->minMax['y'][0] - 1; $y <= $X->minMax['y'][1] + 1; $y++) {
                    for ($z = $X->minMax['z'][0] - 1; $z <= $X->minMax['z'][1] + 1; $z++) {
                        for ($x = $X->minMax['x'][0] - 1; $x <= $X->minMax['x'][1] + 1; $x++) {
                            $res = $X->getNeighborCoords($w, $x, $y, $z);
                            if (isset($X->c[$w][$z][$y][$x]) && !in_array(count($res), [2, 3])) {
                                unset($Xnew->c[$w][$z][$y][$x]);
                            } elseif (!isset($X->c[$w][$z][$y][$x]) && count($res) == 3) {
                                $Xnew->c[$w][$z][$y][$x] = '#';
                                $Xnew->checkMinMax('x', $x, $x);
                                $Xnew->checkMinMax('y', $y, $y);
                                $Xnew->checkMinMax('z', $z, $z);
                            }
                        }
                    }
                }
            }
//            echo PHP_EOL;
            $i++;
            $Xnew->cleanUp();
//            if ($i <= 2) {
//                $Xnew->print($i);
//            }
            $X = clone $Xnew;
        }
        $tot = 0;
        foreach ($X->c as $w) {
            foreach ($w as $y) {
                foreach ($y as $x) {
                    $tot += count($x);
                }
            }
        }

        return (string)$tot;
    }

}
