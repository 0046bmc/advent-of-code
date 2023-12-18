<?php

declare(strict_types=1);

namespace App\Y2022;

use Phaoc\DayBase;
use Phaoc\DayInterface;

class Day05 extends DayBase implements DayInterface
{
    /**
     * @return iterable<string>
     */
    public function testPart1(): iterable
    {
        yield 'CMZ' => file_get_contents(__DIR__ . '/Inputs/day05.test1.txt');
    }

    /**
     * @return iterable<string>
     */
    public function testPart2(): iterable
    {
        yield 'MCD' => file_get_contents(__DIR__ . '/Inputs/day05.test1.txt');
    }

    public function solvePart1(string $input): string
    {
        $data = explode("\n\n", $input);
        $all = $this->extractStack($data[0]);
        return (string)$this->doMoves($all, $data[1]);
    }

    public function solvePart2(string $input): string
    {
        $data = explode("\n\n", $input);
        $all = $this->extractStack($data[0]);
        return $this->doMoves($all, $data[1], true);
    }

    /**
     * @param array<mixed> $all
     * @param string $moves
     * @param bool $is2001
     * @return string
     */
    private function doMoves(array $all, string $moves, bool $is2001 = false): string
    {
        foreach (explode("\n", trim($moves)) as $moveS) {
            preg_match('/move (?<nrOf>\d*) from (?<from>\d*) to (?<to>\d*)/', $moveS, $m);
            $cut = array_splice($all[$m['from']], count($all[$m['from']]) - intval($m['nrOf']));
            $cut = $is2001 ? $cut : array_reverse($cut);
            $all[$m['to']] = array_merge($all[$m['to']], $cut);
        }
        $left = '';
        foreach ($all as $i) {
            $left .= array_pop($i);
        }
        return $left;
    }

    /**
     * @param string $string
     * @return array<mixed>
     */
    private function extractStack(string $string): array
    {
        $bb = explode("\n", $string);
        array_pop($bb);
        $bb = array_reverse($bb);
        $all = [];
        foreach ($bb as $row) {
            $parts = str_split($row, 4);
            foreach ($parts as $pKey => $part) {
                $str = trim($part);
                if ($str) {
                    $all[$pKey + 1][] = substr(trim($part), 1, 1);
                }
            }
        }
        return $all;
    }
}
