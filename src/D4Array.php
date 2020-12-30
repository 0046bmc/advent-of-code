<?php

namespace mahlstrom;

class D4Array
{
    public array $minMax = [
        'w' => [],
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
        $this->checkMinMax('w', min(array_keys($this->c)), max(array_keys($this->c)));
        foreach ($this->c as $w => $wgrid) {
            $this->checkMinMax('z', min(array_keys($wgrid)), max(array_keys($wgrid)));
            foreach ($wgrid as $z => $zgrid) {
                $this->checkMinMax('y', min(array_keys($zgrid)), max(array_keys($zgrid)));
                foreach ($zgrid as $y => $xrow) {
                    $this->checkMinMax('x', min(array_keys($xrow)), max(array_keys($xrow)));
                    if ($removeDots) {
                        foreach ($xrow as $x => $val) {
                            if ($val == '.') {
                                unset($this->c[$w][$z][$y][$x]);
                            }
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
        $this->minMax = [
            'w' => [],
            'z' => [],
            'y' => [],
            'x' => []
        ];
        $this->removeEmpty();

        $this->setMinMax();
    }

    private function removeEmpty(): void
    {
        do{
        $removed = false;
        foreach ($this->c as $w => $wgrid) {
            if (!count($wgrid)) {
                unset($this->c[$w]);
                $removed = true;
                continue;
            }
            foreach ($wgrid as $z => $zgrid) {
                if (!count($zgrid)) {
                    unset($this->c[$w][$z]);
                    $removed = true;
                    continue;
                }
                foreach ($zgrid as $y => $xrow) {
                    if (!count($xrow)) {
                        unset($this->c[$w][$z][$y]);
                        $removed = true;
                        continue;
                    }
                }
            }
        }
        }while($removed==true);
    }

    public function print($nr)
    {
        echo 'After ' . $nr . ' ' . (($nr == 1) ? 'cycle' : 'cycles') . ':' . PHP_EOL . PHP_EOL;
        for ($w = $this->minMax['w'][0]; $w <= $this->minMax['w'][1]; $w++) {
            for ($z = $this->minMax['z'][0]; $z <= $this->minMax['z'][1]; $z++) {
                echo 'z=' . $z . ', w=' . $w . PHP_EOL;
                for ($y = $this->minMax['y'][0]; $y <= $this->minMax['y'][1]; $y++) {
                    for ($x = $this->minMax['x'][0]; $x <= $this->minMax['x'][1]; $x++) {
                        if (isset($this->c[$w]) && isset($this->c[$w][$z]) && isset($this->c[$w][$z][$y]) && isset($this->c[$w][$z][$y][$x])) {
                            echo $this->c[$w][$z][$y][$x];
                        } else {
                            echo '.';
                        }
                    }
                    echo PHP_EOL;
                }
                echo PHP_EOL;
            }
        }
    }

    public function getNeighbors($w, $x, $y, $z)
    {
        $ret = [];
        for ($wp = -1; $wp <= 1; $wp++) {
            for ($zp = -1; $zp <= 1; $zp++) {
                for ($yp = -1; $yp <= 1; $yp++) {
                    for ($xp = -1; $xp <= 1; $xp++) {
                        if ($wp == 0 && $zp == 0 && $yp == 0 && $xp == 0) {
                            continue;
                        }
                        if (isset($this->c[$w + $wp][$z + $zp][$y + $yp][$x + $xp])) {
                            $ret[] = [($w + $wp), ($z + $zp), ($y + $yp), ($x + $xp)];
                        }
                    }
                }
            }
        }
        return $ret;
    }
}