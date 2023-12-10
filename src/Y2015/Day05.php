<?php

declare(strict_types=1);

namespace App\Y2015;

use Phaoc\DayBase;
use Phaoc\DayInterface;

class Day05 extends DayBase implements DayInterface
{
    public function testPart1(): iterable
    {
        yield '1' => 'ugknbfddgicrmopn';
        yield '1' => 'aaa';
        yield '0' => 'jchzalrnumimnmhp';
        yield '0' => 'haegwjzuvuyypxyu';
        yield '0' => 'dvszwmarrgswjxmb';
    }

    public function testPart2(): iterable
    {
        yield '1' => 'qjhvhtzxzqqjkmpb';
        yield '1' => 'xxyxx';
        yield '0' => 'uurcxstgmygtbstg';
        yield '0' => 'ieodomkazucvgmuy';
    }

    public function solvePart1(string $input): string
    {
        $input = $this->parseInput($input);
        $nice = 0;
        foreach ($input as $in) {
            if (
                count(preg_split('/[aeiou]/', $in)) > 3 &&
                $this->checkTwice($in) &&
                preg_match('/(ab|cd|pq|xy)/', $in) === 0
            ) {
                $nice += 1;
            }
        }
        return (string)$nice;
    }

    private function checkTwice(string $string): bool
    {
        $last = '';
        for ($i = 0; $i < strlen($string); $i++) {
            if ($string[$i] == $last) {
                return true;
            }
            $last = $string[$i];
        }
        return false;
    }

    public function solvePart2(string $input): string
    {
        $input = $this->parseInput($input);
        $nice = 0;

        foreach ($input as $in) {
            $dd = $ss = 0;
            for ($i = 0; $i < strlen($in); $i++) {
                $d = substr($in, $i, 2);
                $s = $in[$i];
                if ($i + 2 < strlen($in)) {
                    if ($in[$i + 2] == $s) {
                        $ss++;
                    }
                    if (strpos($in, $d, $i + 2)) {
                        $dd++;
                    }
                }
            }

            if ($ss > 0 && $dd > 0) {
                $nice++;
            }
        }

        return (string)$nice;
    }
}
