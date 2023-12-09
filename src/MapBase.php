<?php

namespace App;

use InvalidArgumentException;

abstract class MapBase
{
    /** @var array<array<int>> */
    public array $minMax;

    /**
     * @param array<string|int> $pos
     * @param int $nr
     * @return void
     */
    protected function checkPosCount(array $pos, int $nr): void
    {
        if (count($pos) != $nr) {
            throw new InvalidArgumentException('Number of arguments in pos not matching: ' . $nr);
        }
    }

    public function checkMinMax(string $plane, int $min, int $max): void
    {
        if (
            !isset($this->minMax[$plane][0]) ||
            $this->minMax[$plane][0] > $min
        ) {
            $this->minMax[$plane][0] = $min;
        }
        if (!isset($this->minMax[$plane][1]) || $this->minMax[$plane][1] < $max) {
            $this->minMax[$plane][1] = $max;
        }
    }
}
