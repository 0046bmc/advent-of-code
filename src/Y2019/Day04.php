<?php

declare(strict_types=1);

namespace App\Y2019;

use Phaoc\DayBase;
use Phaoc\DayInterface;

class Day04 extends DayBase implements DayInterface
{
    /**
     * @return iterable<string>
     */
    public function testPart1(): iterable
    {
        yield '945' => '264360-746325';
        yield '979' => '256310-732736';
        yield '1665' => '158126-624574';
    }

    /**
     * @return iterable<string>
     */
    public function testPart2(): iterable
    {
        yield '617' => '264360-746325';
        yield '635' => '256310-732736';
        yield '1131' => '158126-624574';
    }

    public function solvePart1(string $input): string
    {
        $input = $this->parseInput($input, delimiter: '-');
        $count = 0;
        $code = $input[0];
        do {
            if ($this->isDoubleNumber($code)) {
                $count++;
            }
            $code = (string)$this->ninc($code);
        } while ($code <= $input[1]);
        return (string)$count;
    }

    public function solvePart2(string $input): string
    {
        $input = $this->parseInput($input, delimiter: '-');
        $count = 0;
        $code = $input[0];
        do {
            if ($this->isDoubleNumber($code, true)) {
                $count++;
            }
            $code = (string)$this->ninc($code);
        } while ($code <= $input[1]);
        return (string)$count;
    }

    private function isDoubleNumber(string $code, bool $onlyDouble = false): bool | int
    {
        if (!is_string($code)) {
            var_dump($code);
            var_dump($onlyDouble);
        }
        if ($onlyDouble === false) {
            return preg_match('/(\d)\1+/', $code);
        } else {
            if (preg_match_all('/(\d)\1+/', $code, $matches)) {
                foreach ($matches[0] as $match) {
                    if (strlen($match) === 2) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    private function ninc(mixed $n): int
    {
        $n++;
        $s = "$n";
        for ($i = 0; $i < 5; $i++) {
            if ($s[$i + 1] < $s[$i]) {
                $s = substr($s, 0, $i + 1) . str_repeat($s[$i], 6 - $i - 1);
                break;
            }
        }
        return intval($s);
    }
}
