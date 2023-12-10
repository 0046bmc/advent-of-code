<?php

declare(strict_types=1);

namespace App\Y2015;

use Phaoc\DayBase;
use Phaoc\DayInterface;

class Day09 extends DayBase implements DayInterface
{
    /** @var mixed[] */
    private array $towns = [];

    public function testPart1(): iterable
    {
        yield "605" => 'London to Dublin = 464
London to Belfast = 518
Dublin to Belfast = 141';
    }

    public function testPart2(): iterable
    {
        return [];
    }

    public function solvePart1(string $input): string
    {
        $input = $this->parseInput($input);
        $towns = [];
        foreach ($input as $row) {
            preg_match('/(\w+) to (\w*) = ([0-9]+)/', $row, $out);
            $this->towns[$out[1]][$out[2]] = $out[3];
            $this->towns[$out[2]][$out[1]] = $out[3];
        }
        print_r($this->path('London', ['London' => true]));
        return '';
    }

    /**
     * @param string $from
     * @param mixed[] $destinations
     * @return bool|mixed[]
     */
    private function path(string $from, array $destinations): bool | array
    {
        $not_traveled_to = array_diff_key($this->towns, $destinations);
        $d = [];
        if (count($not_traveled_to) == 0) {
            return false;
        }
        foreach ($not_traveled_to as $key => $val) {
            echo '->' . $key . '(' . ($this->towns[$from][$key]) . ')';
            $res = $this->path($key, array_merge($destinations, [$key => true]));
            if ($res) {
                $d[$key] = $res;
            } else {
                $d[$key] = $val;
            }

            echo PHP_EOL;
        }
        return $d;
    }

    public function solvePart2(string $input): string
    {
        $input = $this->parseInput($input);
        return '';
    }
}
