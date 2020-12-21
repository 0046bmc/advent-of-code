<?php

declare(strict_types=1);

namespace App\Event\Year2020;

use AdventOfCode\DayBase;
use AdventOfCode\DayInterface;
use App\Event\Year2020\Helpers\Ticket;

class Day16 extends DayBase implements DayInterface
{
    public function testPart1(): iterable
    {
        yield '71' => 'class: 1-3 or 5-7
row: 6-11 or 33-44
seat: 13-40 or 45-50

your ticket:
7,1,14

nearby tickets:
7,3,47
40,4,50
55,2,20
38,6,12';
    }

    public function testPart2(): iterable
    {
        yield '71' => 'class: 0-1 or 4-19
row: 0-5 or 8-19
seat: 0-13 or 16-19

your ticket:
11,12,13

nearby tickets:
3,9,18
15,1,5
5,14,9';
    }

    public function solvePart1(string $input): string
    {
        Ticket::parseTickets($input);
        return (string)Ticket::getSumIll();
    }

    public function solvePart2(string $input): string
    {
        Ticket::parseTickets($input);

        return (string)Ticket::get2();
    }
}
