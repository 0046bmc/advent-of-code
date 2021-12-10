<?php

declare(strict_types=1);

namespace App\Event\Year2021;

use AdventOfCode\DayBase;
use AdventOfCode\DayInterface;

class Day10 extends DayBase implements DayInterface
{
    public const chPair = [
        '(' => ')',
        '[' => ']',
        '{' => '}',
        '<' => '>',
    ];
    public const VALUEP2 = [
        ')' => 1,
        ']' => 2,
        '}' => 3,
        '>' => 4
    ];

    public function testPart1(): iterable
    {
        yield '26397' => '[({(<(())[]>[[{[]{<()<>>
[(()[<>])]({[<{<<[]>>(
{([(<{}[<>[]}>{[]{[(<()>
(((({<>}<{<{<>}{[]{[]{}
[[<[([]))<([[{}[[()]]]
[{[{({}]{}}([{[{{{}}([]
{<[[]]>}<{[{[{[]{()[[[]
[<(<(<(<{}))><([]([]()
<{([([[(<>()){}]>(<<{{
<{([{{}}[<[[[<>{}]]]>[]]';
    }

    public function testPart2(): iterable
    {
        yield '288957' => '[({(<(())[]>[[{[]{<()<>>
[(()[<>])]({[<{<<[]>>(
{([(<{}[<>[]}>{[]{[(<()>
(((({<>}<{<{<>}{[]{[]{}
[[<[([]))<([[{}[[()]]]
[{[{({}]{}}([{[{{{}}([]
{<[[]]>}<{[{[{[]{()[[[]
[<(<(<(<{}))><([]([]()
<{([([[(<>()){}]>(<<{{
<{([{{}}[<[[[<>{}]]]>[]]';
    }

    public function solvePart1(string $input): string
    {
        $input = $this->parseInput($input);
        $value = [
            ')' => 3,
            ']' => 57,
            '}' => 1197,
            '>' => 25137
        ];


        $sum = 0;
        /** @var string $row */
        foreach ($input as $row) {
            $rest = $this->reduce($row);
            preg_match('/(\)|>|\}|\])/',$rest,$c);
            if(count($c)>1){
                $sum += $value[$c[1]];
            }
        }
        return (string)$sum;
    }

    public function solvePart2(string $input): string
    {
        $input = $this->parseInput($input);
        $ans = [];
        foreach ($input as $row) {
            $rest = $this->reduce($row);
            preg_match('/(\)|>|\}|\])/',$rest,$c);
            if(count($c)==0){
                $ans[] = $this->calcAutocomplete($rest);
            }
        }
        sort($ans);
        $key = floor(count($ans) / 2);

        return (string)$ans[$key];
    }

    /**
     * @param mixed $string
     * @return mixed
     */
    private function reduce(string $string): string
    {
        $chunks = ['<>', '()', '{}', '[]'];
        do {
            $new = str_replace($chunks, '', $string);
            $match = ($new == $string);
            $string = $new;
        } while ($match == false);
        return $string;
    }

    private function calcAutocomplete($row): int
    {
        $tot = 0;
        for ($i = strlen($row) - 1; $i >= 0; $i--) {
            $tot *= 5;
            $tot += self::VALUEP2[self::chPair[$row[$i]]];
        }
        return $tot;
    }
}
