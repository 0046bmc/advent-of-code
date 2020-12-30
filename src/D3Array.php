<?php

namespace mahlstrom;

class D3Array
{
    public array $minMax = [
        'z' => [],
        'y' => [],
        'x' => []
    ];

    public function __construct(public array $c)
    {
        $this->setMinMax(true);
    }

    private function setMinMax($removeDots = false): void
    {
        $this->checkMinMax('z', min(array_keys($this->c)), max(array_keys($this->c)));
        foreach ($this->c as $z => $zgrid) {
            $this->checkMinMax('y', min(array_keys($zgrid)), max(array_keys($zgrid)));
            foreach ($zgrid as $y => $xrow) {
                $this->checkMinMax('x', min(array_keys($xrow)), max(array_keys($xrow)));
                if ($removeDots) {
                    foreach ($xrow as $x => $val) {
                        if ($val == '.') {
                            unset($this->c[$z][$y][$x]);
                        }
                    }
                }
            }
        }
    }

    public function checkMinMax($dir, $min, $max)
    {
        if (!isset($this->minMax[$dir][0]) || $this->minMax[$dir][0] > $min) {
            $this->minMax[$dir][0] = $min;
        }
        if (!isset($this->minMax[$dir][1]) || $this->minMax[$dir][1] < $max) {
            $this->minMax[$dir][1] = $max;
        }
    }

    public function cleanUp()
    {
        foreach ($this->c as $z => $zgrid) {
            if (!count(array_keys($zgrid))) {
                unset($this->c[$z]);
                continue;
            }

            foreach ($zgrid as $y => $xrow) {
                if (!count(array_keys($xrow))) {
                    unset($this->c[$z][$y]);
                    continue;
                }
            }
        }
        $this->minMax = [
            'z' => [],
            'y' => [],
            'x' => []
        ];
        $this->setMinMax();
    }

    public function oprint()
    {
        for ($y = $this->minMax['y'][0]; $y <= $this->minMax['y'][1]; $y++) {
            for ($z = $this->minMax['z'][0]; $z <= $this->minMax['z'][1]; $z++) {
                for ($x = $this->minMax['x'][0]; $x <= $this->minMax['x'][1]; $x++) {
                    if (isset($this->c[$z]) && isset($this->c[$z][$y]) && isset($this->c[$z][$y][$x])) {
                        echo $this->c[$z][$y][$x];
                    } else {
                        echo '.';
                    }
                }
                echo ' ';
            }
            echo PHP_EOL;
        }
    }

    public function print($nr)
    {
        echo 'After ' . $nr . ' '.(($nr == 1) ? 'cycle' : 'cycles').':'.PHP_EOL.PHP_EOL;
        for ($z = $this->minMax['z'][0]; $z <= $this->minMax['z'][1]; $z++) {
            echo 'z='.$z.PHP_EOL;
            for ($y = $this->minMax['y'][0]; $y <= $this->minMax['y'][1]; $y++) {
                for ($x = $this->minMax['x'][0]; $x <= $this->minMax['x'][1]; $x++) {
                    if (isset($this->c[$z]) && isset($this->c[$z][$y]) && isset($this->c[$z][$y][$x])) {
                        echo $this->c[$z][$y][$x];
                    } else {
                        echo '.';
                    }
                }
                echo PHP_EOL;
            }
            echo PHP_EOL;
        }
    }

    public function getNeighbors($x, $y, $z)
    {
        $ret = [];
        for ($zp = -1; $zp <= 1; $zp++) {
            for ($yp = -1; $yp <= 1; $yp++) {
                for ($xp = -1; $xp <= 1; $xp++) {
                    if ($zp == 0 && $yp == 0 && $xp == 0) {
                        continue;
                    }
                    if (isset($this->c[$z + $zp][$y + $yp][$x + $xp])) {
                        $ret[] = [($z + $zp), ($y + $yp), ($x + $xp)];
                    }
                }
            }
        }
        return $ret;
    }
}