<?php

namespace App\Y2022\Helpers;

class RPS
{
    public int $A = 1; // ROCK
    public int $B = 2; // PAPER
    public int $C = 3; // SCISSORS

    public int $p1 = 0;
    public int $p2 = 0;

    public function doRound(string $p1, string $p2): void
    {
        if ($p1 == $p2) {
            $this->p1 += 3 + $this->$p1;
            $this->p2 += 3 + $this->$p2;
            return;
        }
        switch ($p1 . $p2) {
            case 'AC':
            case 'BA':
            case 'CB':
                $this->p1 += $this->$p1 + 6;
                $this->p2 += $this->$p2;
                break;
            default:
                $this->p2 += $this->$p2 + 6;
                $this->p1 += $this->$p1;
        }
    }
}
