<?php

namespace App;

use ArrayAccess;

class Map2D extends MapBase implements MapInterface, ArrayAccess
{
    public mixed $defaultGridValue = 0;
    public int $nrOf = 0;

    /**
     * @param array<array<string>> $c
     */
    public function __construct(public array $c = [])
    {
        foreach ($this->c as $y => $col) {
            foreach ($col as $x => $val) {
                $this->nrOf++;
            }
        }
    }

    public static function createFromString(string $str)
    {
        $s = self::str2map(trim($str));
        return new Map2D($s);
    }

    /**
     * @param string $str
     * @return array<array<string>>
     */
    public static function str2map(string $str): array
    {
        return array_map('str_split', explode("\n", $str));
    }

    /**
     * @param array<string|int> $path Steps to take [x,y] or [right,down]
     * @param array<string|int> $start Origin [x,y] or [right,down]
     * @param array<string> $c Array of chars to look for
     * @return int
     */
    public function countInPath(array $path, array $start = [0, 0], array $c = ['#']): int
    {
        $i = 0;
        while ($start = $this->findCoordsInPath($path, $start, $c)) {
            $start[0] += $path[0];
            $start[1] += $path[1];
            $i++;
        }
        return $i;
    }

    /**
     * @param array<string|int> $path Steps to take [x,y] or [right,down]
     * @param array<string|int> $start Origin [x,y] or [right,down]
     * @param array<string> $c Array of chars to look for
     * @param bool $loop
     * @return array<string>|bool
     */
    public function findCoordsInPath(array $path, array $start, array $c = ['#'], bool $loop = true): array | bool
    {
        list($right, $down) = $start;
        $width = count($this->c[0]);
        while ($down < count($this->c)) {
            $rr = ($loop) ? $right % $width : $right;
            if (in_array($this->c[$down][$rr], $c)) {
                return [$rr, $down];
            }
            $down += $path[1];
            $right += $path[0];
        }
        return false;
    }

    public function print($nr, $flashed = false): void
    {
        foreach ($this->c as $y => $xAr) {
            foreach ($xAr as $x => $v) {
                if ($flashed && in_array($x . ',' . $y, $flashed)) {
                    echo "\e[0;31m$v\e[0m,";
                } else {
                    echo $v . ',';
                }
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
                $wantedX = $r + $x;
                $wantedY = $d + $y;
                if (!isset($this->c[$wantedY]) || !isset($this->c[$wantedY][$wantedX])) {
                    throw new \UnexpectedValueException(
                        'Pos ' . $wantedX . ':' . $wantedY . ' does not exits when searching around ' . $r .
                        ':' . $d . ' Xmax: ' . $xmax . ' Ymax: ' . $ymax
                    );
                }
                $ret[] = ['x' => ($r + $x), 'y' => ($d + $y), 'v' => $this->c[($d + $y)][($r + $x)]];
            }
        }
        return $ret;
    }

    public function getNeighborCoordsWithKey(int ...$pos): array
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
                $wantedX = $r + $x;
                $wantedY = $d + $y;
                if (!isset($this->c[$wantedY]) || !isset($this->c[$wantedY][$wantedX])) {
                    throw new \UnexpectedValueException(
                        'Pos ' . $wantedX . ':' . $wantedY . ' does not exits when searching around ' . $r .
                        ':' . $d . ' Xmax: ' . $xmax . ' Ymax: ' . $ymax
                    );
                }
                $ret[$wantedX . '-' . $wantedY] = [
                    'x' => ($r + $x),
                    'y' => ($d + $y),
                    'v' => $this->c[($d + $y)][($r + $x)]
                ];
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

    public function cleanUp(): void
    {
        // TODO: Implement cleanUp() method.
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

    public function getLowestNeighbors(int $x, int $y)
    {
        $here = $this->getCoord($x, $y);
        $chords = [$x - 1 => [$y], $x + 1 => [$y], $x => [$y - 1, $y + 1]];

        foreach ($chords as $xx => $yyx) {
            foreach ($yyx as $yy) {
                if ($this->getCoord($xx, $yy) !== false) {
                    echo $xx . ' ' . $yy . ' = ' . $this->getCoord($xx, $yy) . PHP_EOL;
                }

                //                if (($p = $this->getCoord($xx, $yy)) !== false && $p <= $here) {
//                    return false;
//                }
            }
        }
    }

    public function getCoord(int ...$pos): ?string
    {
        $this->checkPosCount($pos, 2);
        [$x, $y] = $pos;
        if (!isset($this->c[$y]) || !isset($this->c[$y][$x])) {
            return $this->defaultGridValue;
        }
        return $this->c[$y][$x];
    }

    public function setCoord(mixed $val, int ...$pos): void
    {
        $this->checkPosCount($pos, 2);
        [$x, $y] = $pos;
        if (!isset($this->c[$y])) {
            $this->c[$y] = [];
        }
        $this->c[$y][$x] = $val;
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

    public function getFullNumber($x, $y)
    {
        $used = [];
        $nAr = [];
        if (is_numeric($this->getCoord($x, $y))) {
            $tx = $x;
            $nAr = [$tx => $this->getCoord($x, $y)];
            $used[] = $tx . '-' . $y;
            while (is_numeric($val = $this->getCoord(--$tx, $y))) {
                $nAr[$tx] = $val;
                $used[] = $tx . '-' . $y;
            }
            $tx = $x;
            while (is_numeric($val = $this->getCoord(++$tx, $y))) {
                $nAr[$tx] = $val;
                $used[] = $tx . '-' . $y;
            }
        }
        ksort($nAr);
        return [join($nAr), $used];
    }

    public static function getDistace($x1, $y1, $x2, $y2)
    {
        return sqrt(pow(($x2 - $x1), 2) + pow(($y2 - $y1), 2));
    }
}
