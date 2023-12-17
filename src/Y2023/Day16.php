<?php

declare(strict_types=1);

namespace App\Y2023;

use App\Map2D;
use App\Y2023\Helpers\MirrorRunner;
use Phaoc\DayBase;
use Phaoc\DayInterface;

class Day16 extends DayBase implements DayInterface
{
    private Map2D $g;

    private $heat = [];
    private $heatDir = [];
    private array $runners = [];
    private array $dir = [];
    private Map2D $p;

    /**
     * @return iterable<string>
     */
    public function testPart1(): iterable
    {
        yield '46' => file_get_contents(__DIR__ . '/Inputs/day16.test1.txt');
    }

    /**
     * @return iterable<string>
     */
    public function testPart2(): iterable
    {
        yield '51' => file_get_contents(__DIR__ . '/Inputs/day16.test1.txt');
    }

    public function solvePart1(string $input): string
    {
        $MR=new MirrorRunner($input);

        $start = [0, 0];
        $dir = 1;

        $ret = $MR->run($start, $dir);

        return (string)$ret;
    }

    public function solvePart2(string $input): string
    {
        $rret=0;
        $MR=new MirrorRunner($input);
        $maxY=count($MR->g->c)-1;
        $maxX=count($MR->g->c[0])-1;
        for($y=0;$y<$maxY;$y++){
            $start = [0, $y];
            $dir = 1;
            $ret = $MR->run($start, $dir);
            if($rret<$ret){
                $rret=$ret;
            }
            $MR=new MirrorRunner($input);
        }
        for($y=0;$y<$maxY;$y++){
            $start = [$maxX, $y];
            $dir = 3;

            $ret = $MR->run($start, $dir);
            if($rret<$ret){
                $rret=$ret;
            }
            $MR=new MirrorRunner($input);
        }
        for($x=0;$x<$maxX;$x++){
            $start = [$x, 0];
            $dir = 2;
            $MR=new MirrorRunner($input);
            $ret = $MR->run($start, $dir);
            if($rret<$ret){
                $rret=$ret;
            }
        }
        for($x=0;$x<$maxX;$x++){
            $start = [$x, $maxY];
            $dir = 2;
            $MR=new MirrorRunner($input);
            $ret = $MR->run($start, $dir);
            if($rret<$ret){
                $rret=$ret;
            }
        }

        return (string)$rret;
    }
}
