<?php

declare(strict_types=1);

namespace App\Y2018;

use Phaoc\DayBase;
use Phaoc\DayInterface;

class Day02 extends DayBase implements DayInterface
{
    public function testPart1(): iterable
    {
        yield '12' => 'abcdef
bababc
abbcde
abcccd
aabcdd
abcdee
ababab';
    }

    public function testPart2(): iterable
    {
        yield 'fgij' => 'abcde
fghij
klmno
pqrst
fguij
axcye
wvxyz';
    }

    public function solvePart1(string $input): string
    {
        $input = $this->parseInput($input);
        $ret = ['2' => 0, '3' => 0];
        foreach ($input as $str) {
            $sa = str_split(chop($str));
            if (count($sa) == count(array_unique($sa))) {
                continue;
            }
            $part = array_unique(array_count_values($sa));
            $part = array_flip(array_values($part));
            foreach ($part as $kk => $dritt) {
                if ($kk == 1) {
                    continue;
                }
                if (in_array($kk, ['2', '3'])) {
                    $ret[$kk]++;
                }
            }
        }
        $ret = $ret['2'] * $ret['3'];
        return (string)$ret;
    }

    public function solvePart2(string $input): string
    {
        $input = $this->parseInput($input);
        $ret = null;
        $nrOf = count($input);
        $len = strlen($input[0]);
        for ($i = 0; $i < $nrOf; $i++) {
            for ($j = $i + 1; $j < $nrOf; $j++) {
                if ($ret = $this->compare($input[$i], $input[$j])) {
                    break;
                }
            }
            if ($ret) {
                break;
            }
        }

        return (string)$ret;
    }
    private function compare(string $org, string $oth): bool | string
    {
        $diffs = 0;
        $len = strlen($org);
        for ($i = 0; $i < $len; $i++) {
            if ($org[$i] !== $oth[$i]) {
                $diffs++;
            }
            if ($diffs > 1) {
                return false;
            }
        }
        $ret = '';
        for ($i = 0; $i < $len; $i++) {
            if ($org[$i] == $oth[$i]) {
                $ret .= $org[$i];
            }
        }
        return $ret;
    }
}
