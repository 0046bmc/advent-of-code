<?php

namespace App;

class Measure
{
    /**
     * @param array<int> $vector1
     * @param array<int> $vector2
     * @return float|int
     */
    public static function distance(array $vector1, array $vector2): float | int
    {
        return (abs($vector1[0] - $vector2[0]) + abs($vector1[1] - $vector2[1]));
    }
}
