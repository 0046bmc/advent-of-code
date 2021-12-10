<?php

declare(strict_types=1);

namespace App\Event\Year2021;

use AdventOfCode\DayBase;
use AdventOfCode\DayInterface;

class Day08 extends DayBase implements DayInterface
{
    public function testPart1(): iterable
    {
        yield '26' => 'be cfbegad cbdgef fgaecd cgeb fdcge agebfd fecdb fabcd edb | fdgacbe cefdb cefbgd gcbe
edbfga begcd cbg gc gcadebf fbgde acbgfd abcde gfcbed gfec | fcgedb cgb dgebacf gc
fgaebd cg bdaec gdafb agbcfd gdcbef bgcad gfac gcb cdgabef | cg cg fdcagb cbg
fbegcd cbd adcefb dageb afcb bc aefdc ecdab fgdeca fcdbega | efabcd cedba gadfec cb
aecbfdg fbg gf bafeg dbefa fcge gcbea fcaegb dgceab fcbdga | gecf egdcabf bgf bfgea
fgeab ca afcebg bdacfeg cfaedg gcfdb baec bfadeg bafgc acf | gebdcfa ecba ca fadegcb
dbcfg fgd bdegcaf fgec aegbdf ecdfab fbedc dacgb gdcebf gf | cefg dcbef fcge gbcadfe
bdfegc cbegaf gecbf dfcage bdacg ed bedf ced adcbefg gebcd | ed bcgafe cdgba cbgef
egadfb cdbfeg cegd fecab cgb gbdefca cg fgcdab egfdb bfceg | gbdfcae bgc cg cgb
gcafb gcf dcaebfg ecagb gf abcdeg gaef cafbge fdbac fegbdc | fgae cfgab fg bagce';
    }

    public function testPart2(): iterable
    {
        yield '61229' => 'be cfbegad cbdgef fgaecd cgeb fdcge agebfd fecdb fabcd edb | fdgacbe cefdb cefbgd gcbe
edbfga begcd cbg gc gcadebf fbgde acbgfd abcde gfcbed gfec | fcgedb cgb dgebacf gc
fgaebd cg bdaec gdafb agbcfd gdcbef bgcad gfac gcb cdgabef | cg cg fdcagb cbg
fbegcd cbd adcefb dageb afcb bc aefdc ecdab fgdeca fcdbega | efabcd cedba gadfec cb
aecbfdg fbg gf bafeg dbefa fcge gcbea fcaegb dgceab fcbdga | gecf egdcabf bgf bfgea
fgeab ca afcebg bdacfeg cfaedg gcfdb baec bfadeg bafgc acf | gebdcfa ecba ca fadegcb
dbcfg fgd bdegcaf fgec aegbdf ecdfab fbedc dacgb gdcebf gf | cefg dcbef fcge gbcadfe
bdfegc cbegaf gecbf dfcage bdacg ed bedf ced adcbefg gebcd | ed bcgafe cdgba cbgef
egadfb cdbfeg cegd fecab cgb gbdefca cg fgcdab egfdb bfceg | gbdfcae bgc cg cgb
gcafb gcf dcaebfg ecagb gf abcdeg gaef cafbge fdbac fegbdc | fgae cfgab fg bagce';
    }

    public function solvePart1(string $input): string
    {
        $nrOf = 0;
        $input = $this->parseInput($input);
        foreach ($input as $row) {
            list($f, $l) = explode(' | ', $row);
            $w = explode(' ', $l);
            foreach ($w as $combination) {
                if (in_array(strlen($combination), [2, 3, 4, 7])) {
                    $nrOf++;
                }
            }
        }
        return (string)$nrOf;
    }

    public function solvePart2(string $input): string
    {
        $input = $this->parseInput($input);
        $tot = 0;
        foreach ($input as $row) {
            $tot += $this->getNumber($row);
        }
        return (string)$tot;
    }

    private function getNumber(string $row): int
    {
        $fin = [];

        list($patterns, $string) = explode(' | ', $row);
        foreach (explode(' ', $patterns) as $pattern) {
            $nrCh[strlen($pattern)][] = str_split($pattern);
        }

        $fin[1] = $nrCh[2][0];
        $fin[4] = $nrCh[4][0];
        $fin[7] = $nrCh[3][0];
        $fin[8] = $nrCh[7][0];

        foreach ($nrCh[6] as $key => $num) {
            if (count(array_intersect($fin[4], $num)) === 4) {
                $fin[9] = $nrCh[6][$key];
                unset($nrCh[6][$key]);
            }
        }
        foreach ($nrCh[6] as $key => $num) {
            if (count(array_intersect($fin[7], $num)) === 3) {
                $fin[0] = $nrCh[6][$key];
                unset($nrCh[6][$key]);
            }
        }
        $fin[6] = array_pop($nrCh[6]);

        foreach ($nrCh[5] as $key => $num) {
            if (count(array_intersect($fin[7], $num)) === 3) {
                $fin[3] = $nrCh[5][$key];
                unset($nrCh[5][$key]);
            }
        }
        foreach ($nrCh[5] as $key => $num) {
            if (count(array_intersect($fin[6], $num)) === 5) {
                $fin[5] = $nrCh[5][$key];
                unset($nrCh[5][$key]);
            }
        }
        $fin[2] = array_pop($nrCh[5]);

        $fin = array_flip(array_map(function($input){
            sort($input);
            return join($input);
        }, $fin));

        $data=array_map(function($str){
            $ar=str_split($str);
            sort($ar);
            return join($ar);
        },explode(' ',$string));

        $ret=0;
        foreach($data as $nr){
            $ret.=$fin[$nr];
        }




        return (int)$ret;
    }
}
