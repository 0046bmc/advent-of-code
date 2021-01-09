<?php

namespace mahlstrom;

class Map2DHex extends MapBase implements MapInterface
{
    public function __construct(public array $c)
    {
    }

    public static function getCoordsDir(int $x, int $y, mixed $dir, $sep = false): string|array
    {
        switch ($dir) {
            case 'se':
                $x += ($y % 2 == 0) ? 1 : 0;
                $y += 1;
                break;
            case 'sw':
                $x -= ($y % 2 == 0) ? 0 : 1;
                $y += 1;
                break;
            case 'ne':
                $x += ($y % 2 == 0) ? 1 : 0;
                $y -= 1;
                break;
            case 'nw':
                $x -= ($y % 2 == 0) ? 0 : 1;
                $y -= 1;
                break;
            case 'e':
                $y -= 0;
                $x += 1;
                break;
            case 'w':
                $y -= 0;
                $x -= 1;
                break;
            default:
                echo $dir . ' not exists';
                exit();
        }
        if ($sep) {
            return array($x, $y);
        } else {
            return join(',', [$x, $y]);
        }
    }

    public function cleanUp()
    {
        foreach ($this->c as $y => $xrow) {
            if (!count(array_keys($xrow))) {
                unset($this->c[$y]);
                continue;
            }
        }
        $this->setMinMax();
    }

    private function setMinMax($removeDots = false): void
    {
        $this->minMax = [
            'y' => [],
            'x' => []
        ];
        $this->checkMinMax('y', min(array_keys($this->c)), max(array_keys($this->c)));
        foreach ($this->c as $y => $xrow) {
            $this->checkMinMax('x', min(array_keys($xrow)), max(array_keys($xrow)));
            if ($removeDots) {
                foreach ($xrow as $x => $val) {
                    if ($val == '.') {
                        unset($this->c[$y][$x]);
                    }
                }
            }
        }
    }

    public function print($nr)
    {
        $minY = $this->minMax['y'][0];
        $maxY = $this->minMax['y'][1];
        $minX = $this->minMax['x'][0];
        $maxX = $this->minMax['x'][1];
        $add = 1;

        $cols = ($maxX + $add) - ($minX - $add);

        for ($y = $minY - $add; $y <= $maxY + $add; $y++) {
            echo C::_((($y % 2) == 0) ? '  |' : '|')->bg('#ffffff');
            for ($x = $minX - $add; $x <= $maxX + $add; $x++) {
                if ($x == 0 && $y == 0) {
                    $v = C::_(' ' . $this->getTileValue((int)$x, (int)$y) . ' ')->bg('#ff0000');
                } else {
                    if ($this->getTileValue((int)$x, (int)$y) == 1) {
                        $v = C::_(' 1 ')->bg('#000000');
                    } else {
                        $v = C::_('   ')->bg('#ffffff');
                    }
                }
                echo C::_('')->bg('#ffffff') . $v . C::_('|')->bg('#ffffff');
            }
            echo C::_((($y % 2) != 0) ? '  ' : '')->bg('#ffffff');
            echo PHP_EOL;
            echo C::_((($y % 2) == 0) ? ' /' : '')->bg('#ffffff');
            echo C::_(str_repeat(' \ /', $cols + 1))->bg('#ffffff');
            echo C::_((($y % 2) != 0) ? ' \ ' : ' ')->bg('#ffffff');
            echo PHP_EOL;
        }
    }

    private function getTileValue(int $x, int $y, string $dir = '')
    {
        if ($dir !== '') {
            list($nx, $ny) = self::getCoordsDir($x, $y, $dir, true);
        } else {
            $nx = $x;
            $ny = $y;
        }
        return $this->getCoord($ny,$nx);
    }

    public function getNeighborCoords(int ...$pos)
    {
    }

    public function getNeighborValues($flatten = false, int ...$pos): array
    {
        $this->checkPosCount($pos,2);
        $y=$pos[0];
        $x=$pos[1];
        $a = [
            'ne' => $this->getTileValue($x, $y, 'ne'),
            'nw' => $this->getTileValue($x, $y, 'nw'),
            'se' => $this->getTileValue($x, $y, 'se'),
            'sw' => $this->getTileValue($x, $y, 'sw'),
            'e' => $this->getTileValue($x, $y, 'e'),
            'w' => $this->getTileValue($x, $y, 'w'),
        ];
        return $a;

    }

    public function getCoord(int ...$pos)
    {
        $this->checkPosCount($pos,2);
        if (!isset($this->c[$pos[0]]) || !isset($this->c[$pos[0]][$pos[1]])) {
            return 0;
        }
        return $this->c[$pos[0]][$pos[1]];
    }

    public function setCoord(int $val, int ...$pos)
    {
        $this->checkPosCount($pos,2);
        if (!isset($this->c[$pos[0]])) {
            $this->c[$pos[0]] = [];
        }
        $this->c[$pos[0]][$pos[1]] = $val;
    }

    public function flatten()
    {
        $ret = [];
        foreach ($this->c as $y => $xrow) {
            foreach ($xrow as $x => $val) {
                $ret[join(',', [$y, $x])] = $val;
            }
        }
        return $ret;
    }
}