<?php

namespace App\Y2020\Helpers;

//TODO: CLEANUP
class Boat
{
    private bool $debug = false;
    public array $pos = ['x' => 0, 'y' => 0];
    public string $facing = 'E';
    public array $wp = ['x' => 10, 'y' => -1];
    /**
     * @var int|mixed
     */
    public int $dist;

    private string $d1 = '%s: %8s H: %s Coord: %s';
    private string $d2 = '%s: %8s H: %s Coord: %s WP: %s';

    public function __construct(array $input, bool $real = false)
    {
        foreach ($input as $cmd) {
            $c = substr($cmd, 0, 1);
            $v = intval(substr($cmd, 1));
            if ($real) {
                switch ($c) {
                    case 'L':
                        $this->turn2($v * -1);
                        break;
                    case 'R':
                        $this->turn2($v);
                        break;
                    case 'F':
                        $this->forward($v);
                        break;
                    default:
                        $this->move2($c, $v);
                }
            } else {
                switch ($c) {
                    case 'L':
                        $this->turn($v * -1);
                        break;
                    case 'R':
                        $this->turn($v);
                        break;
                    case 'F':
                        $this->move($this->facing, $v);
                        break;
                    default:
                        $this->move($c, $v);
                }
            }
        }
        $this->dist = abs($this->pos['x'] + $this->pos['y']);
    }

    private function move($dir, $v)
    {
        switch ($dir) {
            case 'E':
                $this->pos['y'] += $v;
                break;
            case 'W':
                $this->pos['y'] -= $v;
                break;
            case 'S':
                $this->pos['x'] += $v;
                break;
            case 'N':
                $this->pos['x'] -= $v;
                break;
        }
        $this->dump('Move', $dir . ' ' . $v, false);
    }

    private function turn($v)
    {
        $w = ['E', 'S', 'W', 'N'];
        $i = $v / 90;
        $s = (4 + ($i % 4)) % 4;
        $s = (array_search($this->facing, $w) + $s) % 4;
        $this->facing = $w[$s];
        $this->dump('Turn', $v . 'deg', false);
    }

    private function move2($dir, $v)
    {
        switch ($dir) {
            case 'E':
                $this->wp['x'] += $v;
                break;
            case 'W':
                $this->wp['x'] -= $v;
                break;
            case 'S':
                $this->wp['y'] += $v;
                break;
            case 'N':
                $this->wp['y'] -= $v;
                break;
        }
        $this->dump('Move', $dir . ' ' . $v);
    }

    private function turn2($v)
    {
        $cos = cos(deg2rad($v));
        $sin = sin(deg2rad($v));

        $xv = (int)round($this->wp['x'] * $cos - $this->wp['y'] * $sin);
        $yv = (int)round($this->wp['x'] * $sin + $this->wp['y'] * $cos);

        $this->wp['x'] = $xv;
        $this->wp['y'] = $yv;
        $this->dump('Turn', $v . 'deg');
    }

    private function forward(int $v)
    {
        $this->pos['x'] += ($v * $this->wp['x']);
        $this->pos['y'] += ($v * $this->wp['y']);
        $this->dump('Forw', $v);
    }

    private function dump($t, $e, $real = true)
    {
        if (!$this->debug) {
            return;
        }
        $wp = '';
        if ($real) {
            $wp = $this->aDir($this->wp);
        }
        echo sprintf($this->d2, $t, $e, $this->facing, $this->aDir($this->pos), $wp) . PHP_EOL;
    }

    private function aDir(array $x): string
    {
        $s = abs($x['x']);
        $s .= ($x['x'] >= 0) ? 'e' : 'w';
        $s .= ' ' . abs($x['y']);
        $s .= ($x['y'] >= 0) ? 's' : 'n';
        return $s;
    }
}
