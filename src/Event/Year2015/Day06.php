<?php

declare(strict_types=1);

namespace App\Event\Year2015;

use AdventOfCode\DayBase;
use AdventOfCode\DayInterface;
use mahlstrom\Map2D;

class Day06 extends DayBase implements DayInterface
{
    public function testPart1(): iterable
    {
        yield '4'=> 'toggle 0,0 through 1,1';
        yield '285580' => 'toggle 544,218 through 979,872';
//        yield '72930' => 'turn on 226,196 through 599,390';
        yield '12'=>'turn on 0,0 through 3,3
toggle 1,1 through 2,2';
    }

    public function testPart2(): iterable
    {
        yield '1'=>'turn on 0,0 through 0,0';
        yield '2000000'=>'toggle 0,0 through 999,999';
    }

    public function solvePart1(string $input): string
    {
        $input = $this->parseInput($input);
        $grid = new Map2D(array_fill(0, 1000, array_fill(0, 1000, 0)));

        foreach($input as $in){
            $this->do($in,$grid);
        }

        $sum = array_count_values($grid->flat());
        unset($sum[0]);
        return (string)array_sum($sum);
    }

    public function do($string, &$grid)
    {
        preg_match('/^(.*) (\d*),(\d*) through (\d*),(\d*)/', $string, $ar);
        $y1 = $ar[2];
        $x1 = $ar[3];
        $y2 = $ar[4];
        $x2 = $ar[5];
        for ($y = $y1; $y <= $y2; $y++) {
            for ($x = $x1; $x <= $x2; $x++) {
                $grid[$y][$x]=match($ar[1]){
                    'turn on'=>1,
                    'turn off'=>0,
                    'toggle'=>(($grid[$y][$x]+1)%2),
                };
            }
        }
    }
    public function do2($string, &$grid)
    {
        preg_match('/^(.*) (\d*),(\d*) through (\d*),(\d*)/', $string, $ar);
        $y1 = (int)$ar[2];
        $x1 = (int)$ar[3];
        $y2 = (int)$ar[4];
        $x2 = (int)$ar[5];
        for ($y = $y1; $y <= $y2; $y++) {
            for ($x = $x1; $x <= $x2; $x++) {
                $grid[$y][$x]=match($ar[1]){
                    'turn on'=>$grid[$y][$x]+1,
                    'turn off'=>$grid[$y][$x]-1,
                    'toggle'=>$grid[$y][$x]+2,
                };
                if($grid[$y][$x]<0){
                    $grid[$y][$x]=0;
                }
            }
        }
    }

    public function solvePart2(string $input): string
    {
        $input = $this->parseInput($input);
        $grid = new Map2D(array_fill(0, 1000, array_fill(0, 1000, 0)));

        foreach($input as $in){
            $this->do2($in,$grid);
        }
        return (string) array_sum($grid->flat());
    }
}
