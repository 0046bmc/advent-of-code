<?php

namespace App\Y2019\Helpers;

class ICCBase
{
    /**
     * @var int[]
     */
    protected array $memory = [];
    protected int $lastOutput = 0;

    public function peek(int $addr): int
    {
        return $this->memory[$addr];
    }
    public function poke(int $addr, int $value)
    {
        $this->memory[$addr] = $value;
    }
    public function memDump($join_dump = false): array | string
    {
        if ($join_dump) {
            return join(',', $this->memory);
        }
        return $this->memory;
    }
    public function getLastOutput(): int
    {
        return $this->lastOutput;
    }
}
