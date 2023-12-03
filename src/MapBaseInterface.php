<?php

namespace App;

interface MapBaseInterface
{
    public function checkMinMax(string $plane, int $min, int $max): void;
}
