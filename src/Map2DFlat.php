<?php

namespace App;

class Map2DFlat extends MapBase implements MapInterface
{
    public array $c = [];
    public mixed $defaultGridValue = 0;

    private int $xmin = 0;
    private int $xmax = 0;
    private int $ymin = 0;
    private int $ymax = 0;

    public function __construct($c)
    {
        foreach ($c as $x => $col) {
            foreach ($col as $y => $val) {
                if ($x > $this->xmax) {
                    $this->xmax = $x;
                }
                if ($x < $this->xmin) {
                    $this->xmin = $x;
                }
                if ($y > $this->ymax) {
                    $this->ymax = $x;
                }
                if ($y < $this->ymin) {
                    $this->ymin = $x;
                }
                $this->c[$x . ',' . $y] = $val;
            }
        }
    }

    public static function createFromString(string $str): Map2DFlat
    {
        $s = self::str2map(trim($str));
        return new Map2DFlat($s);
    }

    public static function str2map(string $str)
    {
        return array_map('str_split', explode("\n", $str));
    }

    public function getNeighborCoords(int ...$pos): array
    {
        $this->checkPosCount($pos, 2);
        $r = $pos[0];
        $d = $pos[1];

        $xmin = ($r == 0) ? 0 : -1;
        $xmax = ($r == $this->xmax) ? 0 : 1;
        $ymin = ($d == 0) ? 0 : -1;
        $ymax = ($d == $this->ymax) ? 0 : 1;
        $ret = [];
        for ($x = $xmin; $x <= $xmax; $x++) {
            for ($y = $ymin; $y <= $ymax; $y++) {
                if ($y == 0 && $x == 0) {
                    continue;
                }
                $ret[($d + $y) . ',' . ($r + $x)] = [
                    'x' => ($r + $x),
                    'y' => ($d + $y),
                    'v' => $this->c[($d + $y) . ',' . ($r + $x)]
                ];
            }
        }
        return $ret;
    }

    public function cleanUp(): void
    {
        // TODO: Implement cleanUp() method.
    }

    public function print(int $nr): void
    {
        $i = 0;
        foreach ($this->c as $key => $val) {
            echo $val;
            $i++;
            if ($i > $this->xmax) {
                $i = 0;
                echo PHP_EOL;
            }
        }
    }
}
