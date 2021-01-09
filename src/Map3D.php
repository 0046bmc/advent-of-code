<?php

namespace mahlstrom;

class Map3D extends MapBase implements MapInterface
{
    public function __construct(public array $c)
    {
        $this->setMinMax(true);
    }

    private function setMinMax($removeDots = false): void
    {
        $this->minMax = [
            'z' => [],
            'y' => [],
            'x' => []
        ];
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
        $this->setMinMax();
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

    public function getNeighborCoords(int ...$pos): array
    {
        $this->checkPosCount($pos,3);
        $x=$pos[0];
        $y=$pos[1];
        $z=$pos[2];
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