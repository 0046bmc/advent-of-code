<?php
declare(strict_types=1);

namespace App\Event\Year2021;

use AdventOfCode\DayBase;
use AdventOfCode\DayInterface;

class Day01 extends DayBase implements DayInterface
{
    public function testPart1(): iterable
    {
        yield '7' => '199
200
208
210
200
207
240
269
260
263';
    }

    public function testPart2(): iterable
    {
        yield '5' => '199
200
208
210
200
207
240
269
260
263';
    }

    public function solvePart1(string $input): string
    {
        $i=88888888888;
        $inc=0;
        $input = $this->parseInput($input);
        foreach ($input as $t){
            if($t>$i){$inc++;}
            $i=$t;
        }

        return strval($inc);
    }

    public function solvePart2(string $input): string
    {
        $prev=88888888888;
        $inc=0;
        $input = $this->parseInput($input);
        for($i=0;$i<count($input)-2;$i++){
            $sum =array_sum(array_slice($input,$i,3));
            if($sum>$prev){
                $inc++;
            }
            echo $sum.' > '.$prev.PHP_EOL;
            $prev=$sum;
        }

        return strval($inc);
    }
}
