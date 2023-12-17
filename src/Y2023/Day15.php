<?php

declare(strict_types=1);

namespace App\Y2023;

use Phaoc\DayBase;
use Phaoc\DayInterface;

class Day15 extends DayBase implements DayInterface
{
    /**
     * @return iterable<string>
     */
    public function testPart1(): iterable
    {
        yield '1320' => file_get_contents(__DIR__ . '/Inputs/day15.test1.txt');
    }

    /**
     * @return iterable<string>
     */
    public function testPart2(): iterable
    {
        yield '145' => file_get_contents(__DIR__ . '/Inputs/day15.test1.txt');
    }

    public function solvePart1(string $input): string
    {
        $cv = 0;
        $parts = explode(',', chop($input));
        foreach ($parts as $part) {
            $cvp = $this->hashIt($part);
            $cv += $cvp;
        }
        return (string)$cv;
    }

    public function solvePart2(string $input): string
    {
        $parts = explode(',', chop($input));
        $boxes = [];
        foreach ($parts as $part) {
            [$label, $value] = preg_split('/[-|=]/', $part);
            if ($value === '') {
                foreach ($boxes as $boxId => $box) {
                    unset($boxes[$boxId][$label]);
                }
            } else {
                $boxId = $this->hashIt($label);
                $boxes[$boxId][$label] = (int)$value;
            }
        }

        $ret = 0;
        foreach ($boxes as $boxId => $content) {
            $slotId = 1;
            foreach ($content as $focal_length) {
                $ret += (($boxId + 1) * $slotId * $focal_length);
                $slotId++;
            }
        }

        return (string)$ret;
    }

    /**
     * @param string $part
     * @return int
     */
    public function hashIt(string $part): int
    {
        $cvp = 0;
        foreach (str_split($part) as $chr) {
            $cvp += ord($chr);
            $cvp = ($cvp * 17);
            $cvp = $cvp % 256;
        }
        return $cvp;
    }
}
