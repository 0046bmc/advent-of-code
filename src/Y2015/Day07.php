<?php

declare(strict_types=1);

namespace App\Y2015;

use Phaoc\DayBase;
use Phaoc\DayInterface;
use App\Y2015\Helpers\Circuit;

class Day07 extends DayBase implements DayInterface
{
    public function testPart1(): iterable
    {
        yield '132255' => '123 -> x
456 -> y
x AND y -> d
x OR y -> e
x LSHIFT 2 -> f
y RSHIFT 2 -> g
NOT x -> h
NOT y -> i';
    }

    public function testPart2(): iterable
    {
        return [];
    }

    public function solvePart1(string $input): string
    {
        $input = $this->parseInput($input);
        $b = new Circuit($input);
        if ($this->isTest) {
#            var_dump($b->wires);
            if (
                $b->wires['x'] === 123 &&
                $b->wires['y'] === 456 &&
                $b->wires['d'] === 72 &&
                $b->wires['e'] === 507 &&
                $b->wires['f'] === 492 &&
                $b->wires['g'] === 114 &&
                $b->wires['h'] === 65412 &&
                $b->wires['i'] === 65079
            ) {
                return (string)array_sum($b->wires);
            } else {
                return "0";
            }
        } else {
            print_r($b->wires);
            return (string)$b->wires['a'];
        }
    }

    public function solvePart2(string $input): string
    {
        $input = $this->parseInput($input);
        $b = new Circuit($input);
        $b = new Circuit($input, $b->wires['a']);
        return (string)$b->wires['a'];
    }
}
