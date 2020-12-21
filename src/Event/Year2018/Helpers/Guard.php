<?php

namespace App\Event\Year2018\Helpers;

use DateTime;

class Guard
{
    public int $sleepTimes = 0;
    public int $slept = 0;
    public array $hours = [-1 => 0];

    public function __construct(public int $id)
    {
    }

    /**
     * @param DateTime $start
     * @param DateTime $end
     */
    public function sleep(DateTime $start, DateTime $end)
    {
        $this->sleepTimes++;
        $ms = intval($start->format('i'));
        $me = intval($end->format('i'));
        for ($i = $ms; $i < $me; $i++) {
            $this->slept += 1;
            if (!isset($this->hours[$i])) {
                $this->hours[$i] = 0;
            }
            $this->hours[$i]++;
        }
    }

    public function hiMinute(): bool | int | string
    {
        $maxVal = max($this->hours);
        return array_search($maxVal, $this->hours);
    }

    public function freq()
    {
        return max($this->hours);
    }
}
