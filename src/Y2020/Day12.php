<?php

declare(strict_types=1);

namespace App\Y2020;

use Phaoc\DayBase;
use Phaoc\DayInterface;
use App\Y2020\Helpers\Boat;

class Day12 extends DayBase implements DayInterface
{
    /**
     * @return iterable<string>
     */
    public function testPart1(): iterable
    {
        yield '25' => $this->getTestInput();
    }

    /**
     * @return iterable<string>
     */
    public function testPart2(): iterable
    {
        yield '286' => $this->getTestInput();
    }

    public function solvePart1(string $input): string
    {
        $input = $this->parseInput($input);
        $b = new Boat($input);
        return (string)$b->dist;
    }

    public function solvePart2(string $input): string
    {
        $input = $this->parseInput($input);
        $b = new Boat($input, true);
        return (string)$b->dist;
    }
}
