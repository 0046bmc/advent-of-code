<?php
declare(strict_types=1);

namespace App\Event\Year2021;

use AdventOfCode\DayBase;
use AdventOfCode\DayInterface;
use App\Event\Year2021\Helpers\Bingo;

class Day04 extends DayBase implements DayInterface
{
    public function testPart1(): iterable
    {
        yield '4512' => '7,4,9,5,11,17,23,2,0,14,21,24,10,16,13,6,15,25,12,22,18,20,8,19,3,26,1

22 13 17 11  0
 8  2 23  4 24
21  9 14 16  7
 6 10  3 18  5
 1 12 20 15 19

14 21 17 24  4
10 16 15  9 19
18  8 23 26 20
22 11 13  6  5
 2  0 12  3  7

 3 15  0  2 22
 9 18 13 17  5
19  8  7 25 23
20 11 10 24  4
14 21 16 12  6';
    }

    public function testPart2(): iterable
    {
        yield '1924' => '7,4,9,5,11,17,23,2,0,14,21,24,10,16,13,6,15,25,12,22,18,20,8,19,3,26,1

22 13 17 11  0
 8  2 23  4 24
21  9 14 16  7
 6 10  3 18  5
 1 12 20 15 19

14 21 17 24  4
10 16 15  9 19
18  8 23 26 20
22 11 13  6  5
 2  0 12  3  7

 3 15  0  2 22
 9 18 13 17  5
19  8  7 25 23
20 11 10 24  4
14 21 16 12  6';
    }

    public function solvePart1(string $input): string
    {
        $input = $this->parseInput($input);
        $B=new Bingo($input);
        return $B->check();

    }

    public function solvePart2(string $input): string
    {
        $input = $this->parseInput($input);
        $B=new Bingo($input);
        while (count($B->cards)>1){
            $B->check();
        }

        return $B->check();
    }
}
