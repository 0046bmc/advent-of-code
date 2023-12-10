<?php

namespace App;

class Math
{
    /**
     * @param int $x1
     * @param int $y1
     * @param int $x2
     * @param int $y2
     * @return array<string>
     */
    public static function latticePoints(int $x1, int $y1, int $x2, int $y2): array
    {
        $delta_x = $x2 - $x1;
        $delta_y = $y2 - $y1;
        $steps = self::findGreatestCommonDivisor($delta_x, $delta_y);
        $points = array();
        for ($i = 0; $i <= $steps; $i++) {
            $x = $x1 + $i * $delta_x / $steps;
            $y = $y1 + $i * $delta_y / $steps;
            $points[] = "($x,$y)";
        }
        return $points;
    }

    public static function findGreatestCommonDivisor(float | int $a, float | int $b): float | int
    {
        // implement the Euclidean algorithm for finding the greatest
        // common divisor of two integers, always returning a non-negative value
        $a = abs($a);
        $b = abs($b);
        if ($a == 0) {
            return $b;
        } elseif ($b == 0) {
            return $a;
        } else {
            return self::findGreatestCommonDivisor(min($a, $b), max($a, $b) % min($a, $b));
        }
    }
}
