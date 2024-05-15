<?php

declare(strict_types=1);

namespace App\Y2019;

use Phaoc\DayBase;
use Phaoc\DayInterface;
use App\Y2019\Helpers\Path;
use App\Measure;
class Day03 extends DayBase implements DayInterface
{
    private $shortest = PHP_INT_MAX;
    private $steps = PHP_INT_MAX;
    
    /**
     * @return iterable<string>
     */
    public function testPart1(): iterable
    {
        yield '159' => 'R75,D30,R83,U83,L12,D49,R71,U7,L72
U62,R66,U55,R34,D71,R55,D58,R83';
        yield '135' => 'R98,U47,R26,D63,R33,U87,L62,D20,R33,U53,R51
U98,R91,D20,R16,D67,R40,U7,R15,U6,R7';
    }

    /**
     * @return iterable<string>
     */
    public function testPart2(): iterable
    {
        return [];
    }

    public function solvePart1(string $input): string
    {
        $input = $this->parseInput($input);
        $org = new Path($input[0]);
        $O = new Path($input[1], true);
        $this->mapjoin($org, $O);
        return (string)$this->shortest;
    }

    public function solvePart2(string $input): string
    {
        return (string)$this->steps;
    }

    private function mapjoin($org, $O)
    {
        $low = PHP_INT_MAX;
        $ls = PHP_INT_MAX;
        $map = clone($org);
        foreach ($O->fc as $k => $v) {
            list($x, $y) = explode(',', $k);
            if ($k != '0,0' && array_key_exists($k, $org->fc)) {
                $map->fc[$k] = 'X';
                $dis = Measure::distance([0, 0], explode(',', $k));
                if ($dis < $low) {
                    $low = $dis;
                }
                $stp = $org->distCords[$k] + $O->distCords[$k];
                if ($stp < $ls) {
                    $ls = $stp;
                }
            } else {
                $map->drawPos($x, $y, $v);
            }
        }
        $this->shortest = $low;
        $this->steps = $ls;
        return $map;
    }
}
