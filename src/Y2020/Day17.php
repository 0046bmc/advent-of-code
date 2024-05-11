<?php

declare(strict_types=1);

namespace App\Y2020;

use Phaoc\DayBase;
use Phaoc\DayInterface;
use App\Map2D;
use App\Map3D;

class Day17 extends DayBase implements DayInterface
{
    /**
     * @return iterable<string>
     */
    public function testPart1(): iterable
    {
        yield '112' => '.#.
..#
###';
    }

    /**
     * @return iterable<string>
     */
    public function testPart2(): iterable
    {
        yield '848' => '.#.
..#
###';
    }

    public function solvePart1(string $input): string
    {
        $c[0] = Map2D::str2map(chop($input));
        $X = new Map3D($c);
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
        $input = $this->parseInput($input);
        return '';
    }
}
