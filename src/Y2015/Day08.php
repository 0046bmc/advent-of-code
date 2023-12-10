<?php

declare(strict_types=1);

namespace App\Y2015;

use Phaoc\DayBase;
use Phaoc\DayInterface;

class Day08 extends DayBase implements DayInterface
{
    public function testPart1(): iterable
    {
        yield "2" => '""';
        yield "2" => '"abc"';
        yield "3" => '"aaa\"aaa"';
        yield "5" => '"\x27"';
        yield "4" => '"af\\\\fa\""';

        yield "8" => '"aaa\"aaa"
"\x27"';
    }

    public function testPart2(): iterable
    {
        yield "4" => '""';
        yield "4" => '"abc"';
        yield "6" => '"aaa\"aaa"';
        yield "5" => '"\x27"';
    }

    public function solvePart1(string $input): string
    {
        $input = $this->parseInput($input);
        $codeLine = 0;
        $strLine = 0;
        foreach ($input as $row) {
            $codeLine += strlen($row);
            $row2 = preg_replace('/^"(.*)"/', '$1', $row);
            $row2 = preg_replace('/\\\(\\\|"|x[a-f0-9]{2})/', '#', $row2);

            $strLine += strlen($row2);
        }
        return (string)($codeLine - $strLine);
    }

    public function solvePart2(string $input): string
    {
        $input = $this->parseInput($input);
        $codeLine = 0;
        $strLine = 0;
        foreach ($input as $row) {
            $codeLine += strlen($row);
            $row2 = preg_replace('/("|\\\\)/', '\\\\' . '$1', $row);
            $row2 = '"' . $row2 . '"';
            $strLine += strlen($row2);
        }


        return (string)($strLine - $codeLine);
    }
}
