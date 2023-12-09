<?php

namespace App;

interface MapInterface
{
    public function cleanUp(): void;

    public function print(int $nr): void;

    /**
     * @param int ...$pos
     * @return array<int>
     */
    public function getNeighborCoords(int ...$pos): array;

    public function checkMinMax(string $plane, int $min, int $max): void;
}
