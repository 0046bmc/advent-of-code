<?php

declare(strict_types=1);

namespace App\Y2023;

use Phaoc\DayBase;
use Phaoc\DayInterface;

class Day06 extends DayBase implements DayInterface
{
    /**
     * @var int[]
     */
    protected array $times;
    /**
     * @var int[]
     */
    private array $dists;

    /**
     * @return iterable<string>
     */
    public function testPart1(): iterable
    {
        yield '288' => file_get_contents(__DIR__ . '/Inputs/day06.test1.txt');
    }

    /**
     * @return iterable<string>
     */
    public function testPart2(): iterable
    {
        yield '71503' => file_get_contents(__DIR__ . '/Inputs/day06.test1.txt');
    }

    public function solvePart1(string $input): string
    {
        $input = $this->parseInput($input);
        $this->times = $this->rowToIntArray($input[0]);
        $this->dists = $this->rowToIntArray($input[1]);
        return (string)$this->countFaster();
    }

    public function solvePart2(string $input): string
    {
        $input = $this->parseInput($input);
        [$_,$time] = explode(':', $input[0]);
        $time = intval(str_replace(' ', '', $time));
        [$_,$dist] = explode(':', $input[1]);
        $dist = intval(str_replace(' ', '', $dist));

        return (string)$this->getOver($time, $dist);
    }

    /**
     * @param string $row
     * @return array<int>
     */
    private function rowToIntArray(string $row): array
    {
        $ret = preg_split('/\s+/', $row);
        array_shift($ret);
        return array_map('intval', $ret);
    }

    private function countFaster(): int
    {
        $theTime = $this->times[0];
        $key = 0;
        $over = 0;
        $ret = [];
        foreach ($this->times as $key => $theTime) {
            $highScore = $this->dists[$key];

            $over = $this->getOver($theTime, $highScore);


            $ret[] = $over;
        }
        return array_product($ret);
    }

    /**
     * @param int $theTime
     * @param int $highScore
     * @return int
     */
    public function getOver(int $theTime, int $highScore): int
    {
        $over = 0;
        for ($i = 1; $i < $theTime; $i++) {
            $L = $i * ($theTime - $i);
            if ($L > $highScore) {
                $over++;
            }
        }
        return $over;
    }
}
