<?php

namespace mahlstrom;

class Math
{

    public static function latticePoints($x1, $y1, $x2, $y2): array
    {
        $delta_x = $x2 - $x1;
        $delta_y = $y2 - $y1;
        $steps = self::findGreatestCommonDivisor($delta_x, $delta_y);
        $points = array();
        for ($i = 0; $i <= $steps; $i++) {
            $x = $x1 + $i * $delta_x / $steps;
            $y = $y1 + $i * $delta_y / $steps;
            $points[] = "({$x},{$y})";
        }
        return $points;
    }

    public static function findGreatestCommonDivisor($a, $b): float|int
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
                return self::findGreatestCommonDivisor(min($a, $b), max($a, $b) % min($a, $b));
            }
        }
    }
}