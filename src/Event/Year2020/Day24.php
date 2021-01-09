<?php

declare(strict_types=1);

namespace App\Event\Year2020;

use AdventOfCode\DayBase;
use AdventOfCode\DayInterface;
use mahlstrom\Map2DHex;

class Day24 extends DayBase implements DayInterface
{

    private Map2DHex $hex;

    public function testPart1(): iterable
    {
//        yield '1' => 'nwwswee';
        yield '10' => 'sesenwnenenewseeswwswswwnenewsewsw
neeenesenwnwwswnenewnwwsewnenwseswesw
seswneswswsenwwnwse
nwnwneseeswswnenewneswwnewseswneseene
swweswneswnenwsewnwneneseenw
eesenwseswswnenwswnwnwsewwnwsene
sewnenenenesenwsewnenwwwse
wenwwweseeeweswwwnwwe
wsweesenenewnwwnwsenewsenwwsesesenwne
neeswseenwwswnwswswnw
nenwswwsewswnenenewsenwsenwnesesenew
enewnwewneswsewnwswenweswnenwsenwsw
sweneswneswneneenwnewenewwneswswnese
swwesenesewenwneswnwwneseswwne
enesenwswwswneneswsenwnewswseenwsese
wnwnesenesenenwwnenwsewesewsesesew
nenewswnwewswnenesenwnesewesw
eneswnwswnwsenenwnwnwwseeswneewsenese
neswnwewnwnwseenwseesewsenwsweewe
wseweeenwnesenwwwswnew';
    }

    public function testPart2(): iterable
    {
        yield '2208' => 'sesenwnenenewseeswwswswwnenewsewsw
neeenesenwnwwswnenewnwwsewnenwseswesw
seswneswswsenwwnwse
nwnwneseeswswnenewneswwnewseswneseene
swweswneswnenwsewnwneneseenw
eesenwseswswnenwswnwnwsewwnwsene
sewnenenenesenwsewnenwwwse
wenwwweseeeweswwwnwwe
wsweesenenewnwwnwsenewsenwwsesesenwne
neeswseenwwswnwswswnw
nenwswwsewswnenenewsenwsenwnesesenew
enewnwewneswsewnwswenweswnenwsenwsw
sweneswneswneneenwnewenewwneswswnese
swwesenesewenwneswnwwneseswwne
enesenwswwswneneswsenwnewswseenwsese
wnwnesenesenenwwnenwsewesewsesesew
nenewswnwewswnenesenwnesewesw
eneswnwswnwsenenwnwnwwseeswneewsenese
neswnwewnwnwseenwseesewsenwsweewe
wseweeenwnesenwwwswnew';
    }

    public function solvePart1(string $input): string
    {
        $tiles = $this->parseInput($input);
        $hex = new Map2DHex([]);
        foreach ($tiles as $s) {
            $this->buildMap($s, $hex);
        }
        $hex->cleanUp();
        return (string)array_count_values($hex->flatten())[1];
    }

    /**
     * @param mixed $s
     * @param Map2DHex $hex
     * @return mixed
     */
    private function buildMap(mixed $s, Map2DHex $hex)
    {
        $x = 0;
        $y = 0;
        preg_match_all('/((?:se|sw|nw|ne|e|w))/', $s, $ar);
        foreach ($ar[1] as $dir) {
            list($x, $y) = Map2DHex::getCoordsDir($x, $y, $dir, true);
        }
        $hex->setCoord(($hex->getCoord($y, $x) + 1) % 2, $y, $x);
        return $ar;
    }

    public function solvePart2(string $input): string
    {
        $tiles = $this->parseInput($input);
        $this->hex = new Map2DHex([]);
        foreach ($tiles as $s) {
            $this->buildMap($s, $this->hex);
        }
        $this->hex->cleanUp();

        for ($i = 1; $i <= 100; $i++) {
            $this->flipTiles();
            $this->hex->cleanUp();
        }
        return (string)array_count_values($this->hex->flatten())[1];
    }

    private function flipTiles()
    {
        $nv = clone $this->hex;
        $minY = $this->hex->minMax['y'][0];
        $maxY = $this->hex->minMax['y'][1];
        $minX = $this->hex->minMax['x'][0];
        $maxX = $this->hex->minMax['x'][1];
        for ($y = $minY - 2; $y < $maxY + 2; $y++) {
            for ($x = $minX - 2; $x < $maxX + 2; $x += 1) {
                $v = $this->hex->getCoord($y, $x); //$this->getTileValue($x, $y);
                $a = $this->hex->getNeighborValues(false, $y, $x);// $this->getTileAdj($x, (int)$y);
                $nr = array_count_values($a);
                if ($v == 1 && (!isset($nr[1]) || $nr[1] > 2)) {
                    $nv->setCoord(0, $y, $x);
                } elseif ($v == 0 && (isset($nr[1]) && $nr[1] == 2)) {
                    $nv->setCoord(1, $y, $x);
                }
            }
        }
        $this->hex = $nv;
    }
}
