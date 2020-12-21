<?php

declare(strict_types=1);

namespace App\Event\Year2020;

use AdventOfCode\DayBase;
use AdventOfCode\DayInterface;

class Day07 extends DayBase implements DayInterface
{
    public function testPart1(): iterable
    {
        yield '4' => 'light red bags contain 1 bright white bag, 2 muted yellow bags.
dark orange bags contain 3 bright white bags, 4 muted yellow bags.
bright white bags contain 1 shiny gold bag.
muted yellow bags contain 2 shiny gold bags, 9 faded blue bags.
shiny gold bags contain 1 dark olive bag, 2 vibrant plum bags.
dark olive bags contain 3 faded blue bags, 4 dotted black bags.
vibrant plum bags contain 5 faded blue bags, 6 dotted black bags.
faded blue bags contain no other bags.
dotted black bags contain no other bags.';
    }

    public function testPart2(): iterable
    {
        yield '32' => 'light red bags contain 1 bright white bag, 2 muted yellow bags.
dark orange bags contain 3 bright white bags, 4 muted yellow bags.
bright white bags contain 1 shiny gold bag.
muted yellow bags contain 2 shiny gold bags, 9 faded blue bags.
shiny gold bags contain 1 dark olive bag, 2 vibrant plum bags.
dark olive bags contain 3 faded blue bags, 4 dotted black bags.
vibrant plum bags contain 5 faded blue bags, 6 dotted black bags.
faded blue bags contain no other bags.
dotted black bags contain no other bags.';
        yield '126' => 'shiny gold bags contain 2 dark red bags.
dark red bags contain 2 dark orange bags.
dark orange bags contain 2 dark yellow bags.
dark yellow bags contain 2 dark green bags.
dark green bags contain 2 dark blue bags.
dark blue bags contain 2 dark violet bags.
dark violet bags contain no other bags.';
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
