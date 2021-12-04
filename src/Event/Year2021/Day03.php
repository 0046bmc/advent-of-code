<?php

declare(strict_types=1);

namespace App\Event\Year2021;

use AdventOfCode\DayBase;
use AdventOfCode\DayInterface;

class Day03 extends DayBase implements DayInterface
{
    public function testPart1(): iterable
    {
        yield '198' => '00100
11110
10110
10111
10101
01111
00111
11100
10000
11001
00010
01010';
    }

    public function testPart2(): iterable
    {
        yield '230' => '00100
11110
10110
10111
10101
01111
00111
11100
10000
11001
00010
01010';
    }

    public function solvePart1(string $input): string
    {
        $input = $this->parseInput($input);
        $gammaRate = $this->extracted($input);
        $epsilonRate = $this->extracted($input, false);
        return strval(bindec($gammaRate) * bindec($epsilonRate));
    }

    private function extracted(array $input, $high = true): string
    {
        $res = '';
        for ($p = 0; $p < strlen($input[0]); $p++) {
            $ret = $this->getMostCommonAtIndex($input, $p, $high);
            $res .= $ret;
        }
        return $res;
    }

    /**
     * @param array $input
     * @param int $p
     * @param mixed $high
     * @return string
     */
    private function getMostCommonAtIndex(array $input, int $p, bool $high = true): string
    {
        $elements = $this->getArrAtIndex($input, $p);
        $ec = array_count_values($elements);
        if ($ec[0] > $ec[1]) {
            $ret = $high ? '0' : '1';
        } elseif ($ec[0] == $ec[1]) {
            $ret = $high ? '1' : '0';
        } else {
            $ret = $high ? '1' : '0';
        }
        return $ret;
    }

    /**
     * @param int $p
     * @param array $input
     * @return array
     */
    private function getArrAtIndex(array $input, int $p): array
    {
        return array_map(
            function ($i) use (&$p) {
                return $i[$p];
            },
            $input
        );
    }

    public function solvePart2(string $input): string
    {
        $input = $this->parseInput($input);
        $oxygen = $this->extracted2($input);
        $co2 = $this->extracted2($input,false);

        return strval(bindec($oxygen) * bindec($co2));
    }

    private function extracted2(array $input, bool $high = true): string
    {
        $restput = $input;

        for ($p = 0; $p < strlen($input[0]); $p++) {
            $d = $this->getMostCommonAtIndex($restput, $p, $high);
//            var_dump($d);
            $therest = [];
            foreach ($restput as $r) {
                if ($r[$p] == $d) {
                    $therest[] = $r;
                }
            }
//            print_r($therest);
            $restput = $therest;
            if(count($restput)<2){
                break;
            }
        }
        return $restput[0];
    }
}
