<?php

declare(strict_types=1);

namespace App\Y2021;

use Phaoc\DayBase;
use Phaoc\DayInterface;

class Day14 extends DayBase implements DayInterface
{
    public function testPart1(): iterable
    {
        yield '1588' => 'NNCB

CH -> B
HH -> N
CB -> H
NH -> C
HB -> C
HC -> B
HN -> C
NN -> C
BH -> H
NC -> B
NB -> B
BN -> B
BB -> N
BC -> B
CC -> N
CN -> C';
    }

    public function testPart2(): iterable
    {
        yield '2188189693529' => 'NNCB

CH -> B
HH -> N
CB -> H
NH -> C
HB -> C
HC -> B
HN -> C
NN -> C
BH -> H
NC -> B
NB -> B
BN -> B
BB -> N
BC -> B
CC -> N
CN -> C';
    }

    public function solvePart1(string $input): string
    {
        [$pt, $input] = explode("\n\n", $input);
        list($com, $pc, $cc, $inChar, $c) = $this->prep($input, $pt);

        for ($i = 0; $i < 10; $i++) {
            $new = $pc;
            foreach ($pc as $c => $nr) {
                if ($nr > 0) {
                    $new[$com[$c][0]] += $nr;
                    $new[$com[$c][1]] += $nr;
                    $new[$c] -= $nr;
                    $cc[$inChar[$c]] += $nr;
                }
            }
            $pc = $new;
        }
        asort($cc);
        return strval(array_pop($cc) - array_shift($cc));
    }

    public function solvePart2(string $input): string
    {
        [$pt, $input] = explode("\n\n", $input);
        list($com, $pc, $cc, $inChar, $c) = $this->prep($input, $pt);

        for ($i = 0; $i < 40; $i++) {
            $new = $pc;
            foreach ($pc as $c => $nr) {
                if ($nr > 0) {
                    $new[$com[$c][0]] += $nr;
                    $new[$com[$c][1]] += $nr;
                    $new[$c] -= $nr;
                    if ($new[$c] < 0) {
                        die($c);
                    }
                    $cc[$inChar[$c]] += $nr;
                }
            }
            $pc = $new;
        }
        asort($cc);
        return strval(array_pop($cc) - array_shift($cc));
    }

    /**
     * @param string $input
     * @param string $pt
     * @return array<int, array<int|string, array<int, string>|int<0, max>|string>>.
     */
    private function prep(string $input, string $pt): array
    {
        $input = $this->parseInput($input);
        $cc = $pc = $com = $c = [];
        $inChar = [];
        foreach ($input as $row) {
            [$k, $v] = explode(' -> ', $row);
            $inChar[$k] = $v;
            $c = str_split($k);
            $com[$k] = [$c[0] . $v, $v . $c[1]];
            $pc[$k] = 0;
            $cc[$c[0]] = 0;
            $cc[$c[1]] = 0;
        }
        ksort($pc);
        for ($p = 0; $p < strlen($pt) - 1; $p++) {
            $part = substr($pt, $p, 2);
            if (isset($com[$part])) {
                $pc[$part]++;
            } else {
                die('Errno');
            }
        }
        foreach (str_split($pt) as $ch) {
            $cc[$ch] += 1;
        }
        return array($com, $pc, $cc, $inChar, $c);
    }
}
