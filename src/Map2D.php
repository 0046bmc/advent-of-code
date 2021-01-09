<?php

namespace mahlstrom;

class Map2D
{
    public array $a = [];

    public function __construct(string $input)
    {
        foreach (explode("\n", chop($input)) as $y => $str) {
            $this->a[$y] = str_split(chop($str));
        }
    }

    public function set(int $right, int $down, mixed $value)
    {
        $this->a[$down][$right] = $value;
    }

    /**
     * @param array $path Steps to take [x,y] or [right,down]
     * @param array $o Origin [x,y] or [right,down]
     * @param array $c Array of chars to look for
     * @return int
     */
    public function countInPath(array $path, array $o = [0, 0], array $c = ['#'])
    {
        $ret = 0;
        $i = 0;
        while ($o = $this->findCoordsInPath($path, $o, $c, true)) {
            $ret++;
            $o[0] += $path[0];
            $o[1] += $path[1];
            $i++;
        }
        return $i;
    }

    public function findCoordsInPath(array $steps, array $o, array $c = ['#'], bool $loop = true): array|bool
    {
        list($right, $down) = $o;
        $width = count($this->a[0]);
        while ($down < count($this->a)) {
            $rr = ($loop) ? $right % $width : $right;
            if (in_array($this->a[$down][$rr], $c)) {
                return [$rr, $down];
            }
            $down += $steps[1];
            $right += $steps[0];
        }
        return false;
    }

    public function print()
    {
        foreach ($this->a as $y => $xAr) {
            foreach ($xAr as $x => $v) {
                echo $v;
            }
            echo PHP_EOL;
        }
    }

    public function getNeighbors(int $r, int $d, $valArray = true)
    {
        $xmin = ($r == 0) ? 0 : -1;
        $xmax = ($r == count($this->a[0]) - 1) ? 0 : 1;
        $ymin = ($d == 0) ? 0 : -1;
        $ymax = ($d == count($this->a) - 1) ? 0 : 1;
        $ret = [];
        for ($x = $xmin; $x <= $xmax; $x++) {
            for ($y = $ymin; $y <= $ymax; $y++) {
                if ($y == 0 && $x == 0) {
                    continue;
                }
                if ($valArray) {
                    $key = ($r + $x) . ',' . ($d + $y);
                    $ret[$key] = $this->a[($d + $y)][($r + $x)];
                } else {
                    $ret[] = ['x' => ($r + $x), 'y' => ($d + $y), 'v' => $this->a[($d + $y)][($r + $x)]];
                }
            }
        }
        return $ret;
    }
}
