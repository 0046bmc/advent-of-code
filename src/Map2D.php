<?php

namespace mahlstrom;

use ArrayAccess;

class Map2D extends MapBase implements MapInterface, ArrayAccess
{
    public mixed $defaultGridValue = 0;

    public function __construct(public array $c = [])
    {
    }

    public static function createFromString(string $str)
    {
        $s = self::str2map(trim($str));
        return new Map2D($s);
    }

    public static function str2map(string $str)
    {
        return array_map('str_split', explode("\n", $str));
    }

    /**
     * @param array $path Steps to take [x,y] or [right,down]
     * @param array $start Origin [x,y] or [right,down]
     * @param array $c Array of chars to look for
     * @return int
     */
    public function countInPath(array $path, array $start = [0, 0], array $c = ['#']): int
    {
        $ret = 0;
        $i = 0;
        while ($start = $this->findCoordsInPath($path, $start, $c, true)) {
            $ret++;
            $start[0] += $path[0];
            $start[1] += $path[1];
            $i++;
        }
        return $i;
    }

    public function findCoordsInPath(array $steps, array $o, array $c = ['#'], bool $loop = true): array|bool
    {
        list($right, $down) = $o;
        $width = count($this->c[0]);
        while ($down < count($this->c)) {
            $rr = ($loop) ? $right % $width : $right;
            if (in_array($this->c[$down][$rr], $c)) {
                return [$rr, $down];
            }
            $down += $steps[1];
            $right += $steps[0];
        }
        return false;
    }

    public function print($nr)
    {
        foreach ($this->c as $y => $xAr) {
            foreach ($xAr as $x => $v) {
                echo $v;
            }
            echo PHP_EOL;
        }
    }

    public function getNeighborCoords(int ...$pos): array
    {
        $this->checkPosCount($pos, 2);
        $r = $pos[0];
        $d = $pos[1];

        $xmin = ($r == 0) ? 0 : -1;
        $xmax = ($r == count($this->c[0]) - 1) ? 0 : 1;
        $ymin = ($d == 0) ? 0 : -1;
        $ymax = ($d == count($this->c) - 1) ? 0 : 1;
        $ret = [];
        for ($x = $xmin; $x <= $xmax; $x++) {
            for ($y = $ymin; $y <= $ymax; $y++) {
                if ($y == 0 && $x == 0) {
                    continue;
                }
                $ret[] = ['x' => ($r + $x), 'y' => ($d + $y), 'v' => $this->c[($d + $y)][($r + $x)]];
            }
        }
        return $ret;
    }

    public function getNeighborCoordsUDLR(int ...$pos): array
    {
        $this->checkPosCount($pos, 2);
        $r = $pos[0];
        $d = $pos[1];

        $ret = [];

        if (($r + 1) < (count($this->c[0]))) {
            $ret[] = ['x' => ($r + 1), 'y' => ($d + 0), 'v' => $this->c[($d + 0)][($r + 1)]];
        }
        if (($r - 1) >= 0) {
            $ret[] = ['x' => ($r - 1), 'y' => ($d - 0), 'v' => $this->c[($d - 0)][($r - 1)]];
        }

        if (($d + 1) < (count($this->c))) {
            $ret[] = ['x' => ($r + 0), 'y' => ($d + 1), 'v' => $this->c[($d + 1)][($r + 0)]];
        }

        if (($d - 1) >= 0) {
            $ret[] = ['x' => ($r - 0), 'y' => ($d - 1), 'v' => $this->c[($d - 1)][($r - 0)]];
        }

        return $ret;
    }

    public function cleanUp()
    {
        // TODO: Implement cleanUp() method.
    }

    public function setCoord(int $val, int ...$pos)
    {
        $this->checkPosCount($pos, 2);
        if (!isset($this->c[$pos[0]])) {
            $this->c[$pos[0]] = [];
        }
        $this->c[$pos[0]][$pos[1]] = $val;
    }

    public function offsetSet($offset, $value): void
    {
        $colval = [$value];

        if (!is_array($offset)) {
            $this->c[$offset] = $colval;
        } else {
            if (!isset($this->c[$offset[0]])) {
                $this->c[$offset[0]] = array();
            }
            $col = &$this->c[$offset[0]];
            for ($i = 1; $i < sizeof($offset); $i++) {
                if (!isset($col[$offset[$i]])) {
                    $col[$offset[$i]] = array();
                }
                $col = &$col[$offset[$i]];
            }
            $col = $colval;
        }
    }

    public function offsetExists($offset): bool
    {
        if (!is_array($offset)) {
            return isset($this->c[$offset]);
        } else {
            $key = array_shift($offset);
            if (!isset($this->c[$key])) {
                return false;
            }
            $col = &$this->c[$key];
            while ($key = array_shift($offset)) {
                if (!isset($col[$key])) {
                    return false;
                }
                $col = &$col[$key];
            }
            return true;
        }
    }

    public function offsetUnset($offset): void
    {
        if (!is_array($offset)) {
            unset($this->c[$offset]);
        } else {
            $col = &$this->c[array_shift($offset)];
            while (sizeof($offset) > 1) {
                $col = &$col[array_shift($offset)];
            }
            unset($col[array_shift($offset)]);
        }
    }

    public function &offsetGet($offset): mixed
    {
        if (!is_array($offset)) {
            return $this->c[$offset];
        } else {
            $col = &$this->c[array_shift($offset)];
            while (sizeof($offset) > 0) {
                $col = &$col[array_shift($offset)];
            }
            return $col;
        }
    }

    public function flat()
    {
        return self::flatten($this->c);
    }

    public static function flatten($ar)
    {
        $ret = [];
        foreach ($ar as $y => $xrow) {
            foreach ($xrow as $x => $val) {
                $ret[join(',', [$y, $x])] = $val;
            }
        }
        return $ret;
    }

    public function drawLine(array $pt1, array $pt2): void
    {
        foreach (Math::latticePoints($pt1[0], $pt1[1], $pt2[0], $pt2[1]) as $key) {
            $this->c[$key] = isset($this->c[$key]) ? 2 : 1;
        }
    }

    public function isLowestInNeighborhood(int $x, int $y): bool
    {
        $here = $this->getCoord($x, $y);
        $chords = [$x - 1 => [$y], $x + 1 => [$y], $x => [$y - 1, $y + 1]];

        foreach ($chords as $xx => $yyx) {
            foreach ($yyx as $yy) {
                if (($p = $this->getCoord($xx, $yy)) !== false && $p <= $here) {
                    return false;
                }
            }
        }
        return true;
    }

    public function getCoord(int ...$pos)
    {
        $this->checkPosCount($pos, 2);
        if (!isset($this->c[$pos[0]]) || !isset($this->c[$pos[0]][$pos[1]])) {
            return $this->defaultGridValue;
        }
        return $this->c[$pos[0]][$pos[1]];
    }

    public function itterate($func)
    {
        $ret = [];
        foreach ($this->c as $y => $xval) {
            foreach ($xval as $x => $value) {
                $ret[] = $func($x, $y, $value);
            }
        }
        return $ret;
    }
}
