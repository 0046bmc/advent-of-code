<?php

declare(strict_types=1);

namespace App\Y2019;

use Phaoc\DayBase;
use Phaoc\DayInterface;

class Day08 extends DayBase implements DayInterface
{
    /**
     * @return iterable<string>
     */
    public function testPart1(): iterable
    {
        yield '2' => $this->getTestInput();
    }

    /**
     * @return iterable<string>
     */
    public function testPart2(): iterable
    {
        yield '2' => $this->getTestInput();
    }

    public function solvePart1(string $input): string
    {
        $input = $this->parseInput($input);
        $lyrs = str_split($input[0], 25 * 6);
        $max = PHP_INT_MAX;
        $out = false;
        foreach ($lyrs as $layer) {
            $z = substr_count($layer, '0');
            if ($z <= $max) {
                $max = $z;
                $ones = substr_count($layer, '1');
                $twos = substr_count($layer, '2');
                $out = ($ones * $twos);
            }
        }
        return (string)$out;
    }

    public function solvePart2(string $input): string
    {
        $input = $this->parseInput($input);
        $lyrs = str_split($input[0], 25 * 6);
        $out = '';
        for ($i = 0; $i < strlen($lyrs[0]); $i++) {
            if (($i % 25) === 0) {
                $out .= PHP_EOL;
            }
            $p = 2;
            foreach ($lyrs as $layer) {
                if ($layer[$i] < 2) {
                    $p = $layer[$i];
                    break;
                }
            }
            if ($p == 1) {
                $out .= '█';
            } else {
                $out .= ' ';
            }
        }
        return (string)$out;
    }
}
