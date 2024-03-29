<?php

namespace App\Y2023\Helpers;

use App\Map2D;
use Exception;

class MirrorRunner
{
    public Map2D $g;
    /**
     * @var array<int,array<int>>
     */
    private array $runners = [];
    /**
     * @var array|int[]
     */
    private array $dir = [];

    /**
     * @var array<string,bool>
     */
    public array $heat = [];
    /**
     * @var array<string,bool>
     */
    private array $heatDir = [];
    public int $maxX;
    public int $maxY;

    public function __construct(string $input)
    {
        $this->g = Map2D::createFromString($input);
        $this->maxX = (count($this->g->c[0]) - 1);
        $this->maxY = (count($this->g->c) - 1);
    }

    /**
     * @param array<int> $start
     * @param int $dir
     * @return int|null
     * @throws Exception
     */
    public function run(array $start, int $dir): ?int
    {
        $this->runners = [$start];
        $this->dir = [$dir];
        $key = join('-', $start);
        $this->heat = [$key => true];
        $this->heatDir = [];

        while (count($this->runners)) {
            foreach ($this->runners as $runnerId => $runner) {
                $this->checkDir($runnerId);
            }

            foreach ($this->runners as $runnerId => $runner) {
                $this->walk($runnerId);
            }
        }
        return count($this->heat);
    }

    /**
     * @param int $runnerId
     * @return void
     * @throws Exception
     */
    public function checkDir(int $runnerId): void
    {
        $pos = $this->runners[$runnerId];
        $typ = $this->g->getCoord(...$pos);
        switch ($typ) {
            case '/':
                $this->dir[$runnerId] = match ($this->dir[$runnerId]) {
                    0 => 1,
                    1 => 0,
                    2 => 3,
                    3 => 2,
                    default => throw new Exception('this')
                };
                break;
            case '\\':
                $this->dir[$runnerId] = match ($this->dir[$runnerId]) {
                    0 => 3,
                    3 => 0,
                    1 => 2,
                    2 => 1,
                    default => throw new Exception('this')
                };
                break;
            case '|':
                if (in_array($this->dir[$runnerId], [1, 3])) {
                    $this->runners[] = $pos;
                    $this->dir[$runnerId] = 0;
                    $this->dir[] = 2;
                }
                break;
            case '-':
                if (in_array($this->dir[$runnerId], [0, 2])) {
                    $this->runners[] = $pos;
                    $this->dir[$runnerId] = 1;
                    $this->dir[] = 3;
                }
                break;
        }
    }

    private function walk(int $runnerId): void
    {
        [$x, $y] = $this->runners[$runnerId];
        $this->runners[$runnerId] = match ($this->dir[$runnerId]) {
            0 => [$x, ($y - 1)],
            1 => [($x + 1), $y],
            2 => [$x, ($y + 1)],
            3 => [($x - 1), $y],
            default => throw new Exception('this')
        };
        $keyDir = join('-', $this->runners[$runnerId]) . '-' . $this->dir[$runnerId];
        if (
            $this->runners[$runnerId][0] < 0
            || $this->runners[$runnerId][0] >= count($this->g->c[0])
            || $this->runners[$runnerId][1] < 0
            || $this->runners[$runnerId][1] >= count($this->g->c)
            || isset($this->heatDir[$keyDir])
        ) {
            unset($this->runners[$runnerId]);
            unset($this->dir[$runnerId]);
        } else {
            $key = join('-', $this->runners[$runnerId]);
            $this->heat[$key] = true;
            $this->heatDir[$keyDir] = true;
        }
    }
}
