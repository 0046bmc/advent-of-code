<?php

declare(strict_types=1);

namespace App\Event\Year2023;

use App\AoC\DayBase;
use App\AoC\DayInterface;

class Day04 extends DayBase implements DayInterface
{
    /**
     * @return iterable<string>
     */
    public function testPart1(): iterable
    {
        yield '13' => file_get_contents(__DIR__ . '/TestInputs/Day04.1.txt');
    }

    /**
     * @return iterable<string>
     */
    public function testPart2(): iterable
    {
        yield '30' => file_get_contents(__DIR__ . '/TestInputs/Day04.1.txt');
    }

    public function solvePart1(string $input): string
    {
        $tot=0;
        $input = Day04::parseInput2($input);
        foreach ($input as $game=>$v){
            $matches=count(array_intersect($v['w'],$v['m']));
            $tot+=$matches===0?0:pow(2,($matches-1));
        }
        return (string)$tot;
    }

    public function solvePart2(string $input): string
    {
        $input = Day04::parseInput2($input);
        $nrOf=array_fill_keys(array_keys($input),1);
        $gameNr=1;
        foreach ($input as $game=>$v){
            $matches=count(array_intersect($v['w'],$v['m']));
            for($i=$gameNr+1;$i<=$gameNr+$matches;$i++){
                $nrOf['C'.$i]+=($nrOf[$game]);
            }
            $gameNr++;
        }
        return (string)array_sum($nrOf);
    }

    /**
     * @param string $input
     * @return mixed[]
     */
    public static function parseInput2(string $input): array
    {
        $ret=[];
        foreach(explode("\n", chop($input)) as $row){
            list($game,$numbers)=explode(': ',$row);
            list($winning,$mine)=explode(' | ',$numbers);
            $game='C'.intval(substr($game,4));
            $winning=array_map('intval',str_split($winning,3));
            $mine=array_map('intval',str_split($mine,3));
            $ret[$game]=['w'=>$winning,'m'=>$mine];
        }
        return $ret;
    }
}
