<?php

declare(strict_types=1);

namespace App\Event\Year2020;

use AdventOfCode\DayBase;
use AdventOfCode\DayInterface;
use App\Event\Year2020\Helpers\PassWord;
use Exception;

class Day02 extends DayBase implements DayInterface
{
    public function testPart1(): iterable
    {
        yield '2' => '1-3 a: abcde
1-3 b: cdefg
2-9 c: ccccccccc';
    }

    public function testPart2(): iterable
    {
        yield '1' => '1-3 a: abcde
1-3 b: cdefg
2-9 c: ccccccccc';
    }

    public function solvePart1(string $input): string
    {
        $input = $this->parseInput($input);
        $minmax = 0;
        foreach ($input as $r) {
            try {
                $pass = new PassWord($r);
                if ($pass->isMinMax()) {
                    $minmax++;
                }
            } catch (Exception $e) {
                var_dump($e);
                exit(1);
            }
        }
        return (string)$minmax;
    }

    public function solvePart2(string $input): string
    {
        $input = $this->parseInput($input);
        $oneis = 0;
        foreach ($input as $r) {
            try {
                $pass = new PassWord($r);
                if ($pass->isOneOf()) {
                    $oneis++;
                }
            } catch (Exception $e) {
                var_dump($e);
                exit(1);
            }
        }
        return (string)$oneis;
    }
}
