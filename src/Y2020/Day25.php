<?php

declare(strict_types=1);

namespace App\Y2020;

use Phaoc\DayBase;
use Phaoc\DayInterface;

class Day25 extends DayBase implements DayInterface
{
    /**
     * @return iterable<string>
     */
    public function testPart1(): iterable
    {
        yield '14897079' => '5764801
17807724';
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
        $input = array_map('intval', explode("\n", chop($input)));
        $card_loops = $this->getLoopSize(7, $input[0]);
        return (string) $this->transform($input[1], $card_loops);
    }

    public function solvePart2(string $input): string
    {
        $input = $this->parseInput($input);
        return '';
    }

    private function transform($subject_number, $loop_size)
    {
        $value = 1;

        for ($i = 0; $i < $loop_size; $i++) {
            $value *= $subject_number;
            $value = $value % 20201227;
        }
        return $value;
    }

    private function getLoopSize($subject_number, $match)
    {
        $value = 1;
        $i = 0;
        while ($value != $match) {
            $value *= $subject_number;
            $value = $value % 20201227;
            $i++;
        }
        return $i;
    }
}
