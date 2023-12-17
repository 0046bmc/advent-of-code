<?php

namespace App\Y2023\Helpers;

use \Exception;
use App\Map2D;

class MazeRunner
{
    private array $start = [0, 0];
    private array $pos = [0, 0];
    private array|bool $nextPos = [0, 0];
    private int $dir = 0;
    private array $max = [0, 0];
    private array $allowed = [
        0 => ['|', 'F', '7'],
        1 => ['-', '7', 'J'],
        2 => ['|', 'J', 'L'],
        3 => ['-', 'L', 'F'],
    ];

    private MAP2D $m;

    private array $visited = [];
    private function step()
    {
        $this->pos = $this->nextPos;
        $sign = $this->m->getCoord(...$this->pos);
        $this->dir = match ($sign) {
            '|', '-' => $this->dir,
            'F' => $this->dir === 0 ? 1 : 2,
            '7' => $this->dir === 0 ? 3 : 2,
            'J' => $this->dir === 2 ? 3 : 0,
            'L' => $this->dir === 2 ? 1 : 0,
            default=> throw new Exception('whit')
        };
        $this->nextPos = $this->getNextPos();
    }

    public function __construct(string $input)
    {
        $this->m = Map2D::createFromString($input);
        foreach ($this->m->c as $y => $xv) {
            foreach ($xv as $x => $v) {
                if ($v === 'S') {
                    $this->start[0] = $this->pos[0] = $x;
                    $this->start[1] = $this->pos[1] = $y;
                    break 2;
                }
            }
        }
        $this->max[0] = count($this->m->c[0]) - 1;
        $this->max[1] = count($this->m->c) - 1;
    }

    public function walk(bool $getNest = false)
    {
        $next = $this->getNextPos();
        $this->nextPos = false;
        while ($this->nextPos === false) {
            if ($next !== false) {
                $sign = $this->m->getCoord(...$next);
                if (!in_array($sign, $this->allowed[$this->dir])) {
                    $this->dir = ($this->dir + 1) % 4;
                } else {
                    $this->nextPos = $next;
                }
            } else {
                $this->dir = ($this->dir + 1) % 4;
            }
            $next = $this->getNextPos();
        }
        $i = 0;
        $this->visited[] = join(':', $this->pos);
        try {
            while (true) {
                $i++;
                $this->step();
                $this->visited[] = join(':', $this->pos);
            }
        } catch (exception $e) {
        }
        if (!$getNest) {
            return $i / 2;
        }
        foreach ($this->m->c as $y => $xv) {
            foreach ($xv as $x => $v) {
                if (!in_array($x . ':' . $y, $this->visited)) {
                    $this->m->setCoord(1, $x, $y);
                }
                echo $this->m->getCoord($x, $y);
            }
            echo PHP_EOL;
        }
        echo PHP_EOL;

        $y = 0;
        for ($x = 0; $x < count($this->m->c[0]); $x++) {
            $val = $this->m->getCoord($x, $y);
            if (($val) == 1) {
                $this->nFill($x, $y);
            }
        }

        $x = count($this->m->c[0]) - 1;
        for ($y = 0; $y < count($this->m->c); $y++) {
            $val = $this->m->getCoord($x, $y);
            if (($val) == 1) {
                $this->nFill($x, $y);
            }
        }


        $y = count($this->m->c) - 1;
        for ($x = 0; $x < count($this->m->c[0]); $x++) {
            $val = $this->m->getCoord($x, $y);
            if (($val) == 1) {
                $this->nFill($x, $y);
            }
        }



        $this->m->print(1);


        $count = 0;
        foreach ($this->m->c as $y => $xv) {
            foreach ($xv as $x => $v) {
                if ($v == 1) {
                    $count++;
                }
            }
        }
                return $count;
    }
    private function getNextPos(): bool|array
    {
        $coords = match ($this->dir) {
            0 => [$this->pos[0], $this->pos[1] - 1],
            1 => [$this->pos[0] + 1, $this->pos[1]],
            2 => [$this->pos[0], $this->pos[1] + 1],
            3 => [$this->pos[0] - 1, $this->pos[1]],
        };
        if (
            $coords[0] < 0 || $coords[1] < 0 ||
            $coords[0] > $this->max[0] ||
            $coords[1] > $this->max[1]
        ) {
            return false;
        }
        return $coords;
    }

    private function nFill($x, $y)
    {
        $this->m->setCoord('.', $x, $y);
        $n = $this->m->getNeighborCoordsUDLR($x, $y);
        foreach ($n as $nei) {
            if ($nei['v'] === 1) {
                $this->nFill($nei['x'], $nei['y']);
            }
        }
    }
}
