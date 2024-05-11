<?php

declare(strict_types=1);

namespace App\Y2020;

use Phaoc\DayBase;
use Phaoc\DayInterface;
use App\Map2D;

class Day20 extends DayBase implements DayInterface
{
    /**
     * @return iterable<string>
     */
    public function testPart1(): iterable
    {
        yield '20899048083289' => $this->getTestInput();
        // yield '20899048083289' => file_get_contents(__DIR__ . '/TestInputs/Day20.1.txt');
    }

    /**
     * @return iterable<string>
     */
    public function testPart2(): iterable
    {
        yield '273' => $this->getTestInput();
    }

    public function solvePart1(string $input): string
    {
        $match = [];
        $tiles = $this->parseTiles($input);
        $keys = array_keys($tiles);
        for ($i = 0; $i < count($keys); $i++) {
            for ($j = $i + 1; $j < count($keys); $j++) {
                $key1 = $keys[$i];
                $key2 = $keys[$j];
                if ($this->testMatch($tiles[$key1], $tiles[$key2])) {
                    if (!isset($match[$key1])) {
                        $match[$key1] = 0;
                    }
                    if (!isset($match[$key2])) {
                        $match[$key2] = 0;
                    }

                    $match[$key1] += 1;
                    $match[$key2] += 1;
                }
            }
        }
        $a = 1;
        foreach ($match as $k => $v) {
            if ($v == 2) {
                $a *= $k;
            }
        }
        return (string)$a;
    }

    public function solvePart2(string $input): string
    {
        $tiles = $this->parseTiles($input);
        $key = array_key_first($tiles);
        $e = [0 => [0 => $tiles[$key]]];
        unset($tiles[$key]);

        while (count($tiles)) {
            foreach ($tiles as $key => $tile) {
                if ($this->tryFind($tile, $e)) {
                    unset($tiles[$key]);
                }
            }
        }
        $mon = Map2D::str2map('                  # 
#    ##    ##    ###
 #  #  #  #  #  #   ');
        $joined = $this->dumpIt2($e);
        $joined = $this->rotate($joined, 0, flip: false);
        $found = $this->searchMonster($joined, $mon);

        return (string)$found;
    }

    private function parseTiles(string $input)
    {
        $ret = [];
        $tiles = explode("\n\n", chop($input));
        foreach ($tiles as $tile) {
            preg_match("/^Tile (\d*):\n(.*)$/s", $tile, $m);

            $ret[intval($m[1])] = Map2D::str2map($m[2]);
        }
        return $ret;
    }

    private function testMatch($tile1, $tile2, $getOrientation = false)
    {
        $t1 = $this->getBorders($tile1, false);
        $t2 = $this->getBorders($tile2);
        foreach ($t1 as $nr1 => $r1) {
            foreach ($t2 as $nr2 => $r2) {
                if (join('', $r1) == join('', $r2)) {
                    if ($getOrientation) {
                        return [$nr1, $nr2];
                    } else {
                        return true;
                    }
                }
            }
        }
    }

    private function getBorders($tile, $flipped = true)
    {
        if (!$flipped) {
            return [
                'o0' => $this->rotate($tile, 0)[0],
                'o1' => $this->rotate($tile, 1)[0],
                'o2' => $this->rotate($tile, 2)[0],
                'o3' => $this->rotate($tile, 3)[0],
            ];
        } else {
            return [
                'o0' => $this->rotate($tile, 0)[0],
                'o1' => $this->rotate($tile, 1)[0],
                'o2' => $this->rotate($tile, 2)[0],
                'o3' => $this->rotate($tile, 3)[0],
                'f0' => $this->rotate($tile, 0, true)[0],
                'f1' => $this->rotate($tile, 1, true)[0],
                'f2' => $this->rotate($tile, 2, true)[0],
                'f3' => $this->rotate($tile, 3, true)[0],
            ];
        }
    }

    private function rotate($tile, $nr = 0, $flip = false)
    {
        $hiX = count($tile[0]) - 1;
        $hiY = count(array_column($tile, 0)) - 1;
        if ($flip) {
            $tile = array_reverse($tile);
        }
        $ret = [];
        switch ($nr) {
            case 1:
                for ($i = 0; $i <= $hiX; $i++) {
                    $ret[$i] = array_reverse(array_column($tile, $i));
                }
                break;
            case 2:
                for ($i = 0; $i <= $hiY; $i++) {
                    $ret[$i] = array_reverse($tile[$hiY - $i]);
                }
                break;
            case 3:
                for ($i = 0; $i <= $hiX; $i++) {
                    $ret[$i] = array_column($tile, ($hiX - $i));
                }
                break;
            default:
                return $tile;
        }

        return $ret;
    }

    private function tryFind($tile, array &$j): bool
    {
        if ($res = $this->findMatch($tile, $j)) {
            $or = array_map('str_split', $res[2]);
            $ty = $res[0];
            $tx = $res[1];
            switch ($or[0][1]) {
                case '0':
                    $ty -= 1;
                    break;
                case '1':
                    $tx -= 1;
                    break;
                case '2':
                    $ty += 1;
                    break;
                case '3':
                    $tx += 1;
                    break;
                default:
                    die('Direction ' . $or[0][1] . 'does not exist');
            }
            $flipIt = $or[1][0] != 'f';
            $j[$ty][$tx] = $this->rotate($tile, ((8 - $or[0][1] - $or[1][1]) % 4), $flipIt);
            return true;
        }
        return false;
    }

    private function findMatch($tile, $j)
    {
        foreach ($j as $y => $xrow) {
            foreach ($xrow as $x => $m) {
                if ($ret = $this->testMatch($m, $tile, true)) {
                    return [$y, $x, $ret];
                }
            }
        }
    }

    private function dumpIt2(array $j): array
    {
        ksort($j);
        $ret = [0 => []];
        $y = 0;
        foreach ($j as $jk => $p) {
            for ($i = 1; $i < 9; $i++) {
                ksort($p);
                foreach ($p as $dk => $d) {
                    $row = $j[$jk][$dk][$i];
                    array_pop($row);
                    array_shift($row);
                    $ret[$y] = array_merge($ret[$y], $row);
                }
                $y++;
                $ret[$y] = [];
            }
        }
        return $ret;
    }

    private function searchMonster(mixed $joined, array $mon)
    {
        $mons = [
            $this->rotate($mon, 0),
            $this->rotate($mon, 1),
            $this->rotate($mon, 2),
            $this->rotate($mon, 3),
            $this->rotate($mon, 0, true),
            $this->rotate($mon, 1, true),
            $this->rotate($mon, 2, true),
            $this->rotate($mon, 3, true),

        ];
        $d = $joined;
        $count = 0;
        for ($y = 0; $y < count($joined); $y++) {
            for ($x = 0; $x < count($joined[0]); $x++) {
                foreach ($mons as $bb => $mon) {
                    if ($y + count($mon) >= count($joined)) {
                        continue;
                    }
                    if ($x + count($mon[0]) >= count($joined[0])) {
                        continue;
                    }
                    $tot = 0;
                    $match = 0;
                    foreach ($mon as $my => $mrow) {
                        foreach ($mrow as $mx => $v) {
                            $tot++;
                            if ($joined[$y + $my][$x + $mx] == $v) {
                                $match++;
                            }
                        }
                    }
                    if ($match == 15) {
                        $count++;
                        foreach ($mon as $my => $mrow) {
                            foreach ($mrow as $mx => $v) {
                                if ($joined[$y + $my][$x + $mx] == $v) {
                                    $d[$y + $my][$x + $mx] = 'O';
                                    $match++;
                                }
                            }
                        }
                        break;
                    }
                }
            }
        }
        return array_count_values(Map2D::flatten($d))['#'];
    }
}
