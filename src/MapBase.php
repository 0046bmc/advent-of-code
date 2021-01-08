<?php

namespace mahlstrom;

use InvalidArgumentException;

abstract class MapBase
{
    public array $minMax;

    protected function checkPosCount($pos,$nr){
        if(count($pos)!=$nr){
            throw new InvalidArgumentException('Number of arguments in pos not matching: '.$nr);
        }
    }
    public function checkMinMax($plane, $min, $max): void
    {
        if (!isset($this->minMax[$plane][0]) || $this->minMax[$plane][0] > $min) {
            $this->minMax[$plane][0] = $min;
        }
        if (!isset($this->minMax[$plane][1]) || $this->minMax[$plane][1] < $max) {
            $this->minMax[$plane][1] = $max;
        }
    }
}