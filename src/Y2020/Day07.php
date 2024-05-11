<?php

declare(strict_types=1);

namespace App\Y2020;

use Phaoc\DayBase;
use Phaoc\DayInterface;

class Day07 extends DayBase implements DayInterface
{
    /**
     * @return iterable<string>
     */
    public function testPart1(): iterable
    {
        yield '4' => file_get_contents(__DIR__ . '/Inputs/day07.test1.txt');
    }

    /**
     * @return iterable<string>
     */
    public function testPart2(): iterable
    {
        yield '32' => file_get_contents(__DIR__ . '/Inputs/day07.test1.txt');
        yield '126' => file_get_contents(__DIR__ . '/Inputs/day07.test2.txt');
    }

    public function solvePart1(string $input): string
    {
        $input = explode("\n", chop($input));
        $ret = null;
        $contain = $this->parseBags($input);
        $rea = array_unique($this->canContain('shiny gold', $contain));

        return (string)count($rea);
    }

    public function solvePart2(string $input): string
    {
        $input = explode("\n", chop($input));
        $contain = $this->parseBags($input);
        $inc = 'shiny gold';
        return (string)$this->diveIn($contain, $inc);
    }

    public function diveIn(array $contain, string $inc): int
    {
        $ret = 0;
        foreach ($contain[$inc] as $C => $nr) {
            for ($i = 0; $i < $nr; $i++) {
                $ret += $this->diveIn($contain, $C);
                $ret++;
            }
        }
        return $ret;
    }

    private function canContain(string $inc, array $contain): array
    {
        $C = [];
        foreach ($contain as $bc => $c) {
            if (isset($c[$inc])) {
                $C = array_merge($this->canContain($bc, $contain), $C, [$bc]);
            }
        }
        return $C;
    }


    public function parseBags(array $input): array
    {
        $contain = [];
        foreach ($input as $row) {
            $p = explode(' bags contain ', $row);
            preg_match_all('/(\d*) ([a-z ]*) bags?/', $p[1], $c);
            foreach ($c[2] as $k => $color) {
                if ($color == 'other') {
                    $contain[$p[0]] = [];
                    continue;
                }
                $contain[$p[0]][$color] = $c[1][$k];
            }
        }
        return $contain;
    }
}
