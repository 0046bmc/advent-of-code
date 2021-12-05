<?php

namespace App\Event\Year2021\Helpers;

use mahlstrom\Map2D;

class Grid2D
{
    public array $points = [];

    public function drawLine(array $pt1, array $pt2): void
    {
        foreach ($this->lattice_points($pt1[0], $pt1[1], $pt2[0], $pt2[1]) as $key) {
            $this->points[$key] = isset($this->points[$key]) ? 2 : 1;
        }
    }

    private function lattice_points($x1, $y1, $x2, $y2)
    {
        $delta_x = $x2 - $x1;
        $delta_y = $y2 - $y1;
        $steps = $this->gcd($delta_x, $delta_y);
        $points = array();
        for ($i = 0; $i <= $steps; $i++) {
            $x = $x1 + $i * $delta_x / $steps;
            $y = $y1 + $i * $delta_y / $steps;
            $points[] = "({$x},{$y})";
        }
        return $points;
    }

    private function gcd($a, $b)
    {
        // implement the Euclidean algorithm for finding the greatest common divisor of two integers, always returning a non-negative value
        $a = abs($a);
        $b = abs($b);
        if ($a == 0) {
            return $b;
        } else {
            if ($b == 0) {
                return $a;
            } else {
                return $this->gcd(min($a, $b), max($a, $b) % min($a, $b));
            }
        }
    }

}