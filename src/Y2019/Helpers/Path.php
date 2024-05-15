<?php

namespace App\Y2019\Helpers;

class Path
{
    private string $lod = '|';
    private string $vag = '-';
    private string $xrs = '+';
    private int $steps = 0;
    public int $lx = 0;
    public int $ly = 0;
    public int $x = 0;
    public int $y = 0;
    private array $c = ['x' => 0, 'y' => 0];
    public array $coords = [0 => ['o']];
    public array $fc = ['0,0' => 'o'];
    public array $justCoords;
    public array $distCords;

    public function __construct($str, $dd = false)
    {
        if ($dd) {
            $this->vag = $this->lod = $this->xrs = '*';
        }
        $sPath1 = explode(',', $str);
        foreach ($sPath1 as $r) {
            $dir = $r[0];
            $steps = intval(substr($r, 1));

            switch ($dir) {
                case 'U':
                    $this->move('y', '+', $steps);
                    break;
                case 'D':
                    $this->move('y', '-', $steps);
                    break;
                case 'R':
                    $this->move('x', '+', $steps);
                    break;
                case 'L':
                    $this->move('x', '-', $steps);
                    break;
            }
        }
    }

    private function move($v, $t, $s)
    {
        $sign = $this->lod;
        if ($v == 'x') {
            $sign = $this->vag;
        }
        for ($i = 0; $i < $s; $i++) {
            if ($t == '+') {
                $this->c[$v]++;
            } else {
                $this->c[$v]--;
            }
            if ($i == $s - 1) {
                $sign = $this->xrs;
            }
            $this->drawPos($this->c['x'], $this->c['y'], $sign);
        }
    }

    public function drawPos($x, $y, $ch)
    {
#        echo "X: $x Y: $y".PHP_EOL;
        $xy = "$x,$y";
        $this->justCoords[] = [$x, $y];
        $this->steps++;
        $this->distCords[$xy] = $this->steps;
        $this->fc[$xy] = $ch;
        $this->coords[$x][$y] = $ch;
        if ($x > $this->x) {
            $this->x = $x;
        }
        if ($y > $this->y) {
            $this->y = $y;
        }
        if ($x < $this->lx) {
            $this->lx = $x;
        }
        if ($y < $this->ly) {
            $this->ly = $y;
        }
    }
}
