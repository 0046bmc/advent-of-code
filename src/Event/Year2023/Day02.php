<?php

declare(strict_types=1);

namespace App\Event\Year2023;

use App\AoC\DayBase;
use App\AoC\DayInterface;

class Day02 extends DayBase implements DayInterface
{
    /**
     * @return iterable<string>
     */
    public function testPart1(): iterable
    {
        yield '8' => file_get_contents(__DIR__ . '/TestInputs/Day02.1.txt');
    }

    /**
     * @return iterable<string>
     */
    public function testPart2(): iterable
    {
        yield '2286' => file_get_contents(__DIR__ . '/TestInputs/Day02.1.txt');
    }

    public function solvePart1(string $input): string
    {
        $ret = 0;
        $input = $this->parseInput($input);
        foreach ($input as $row) {
            $row = explode(': ', $row);
            $gameNr = intval(str_replace('Game ', '', $row[0]));
            $pulls = explode('; ', $row[1]);
            if ($this->extracted($pulls)) {
                $ret += $gameNr;
            }
        }
        return (string)$ret;
    }

    public function solvePart2(string $input): string
    {
        $ret = 0;
        $input = $this->parseInput($input);
        foreach ($input as $row) {
            $row = explode(': ', $row);
            $pulls = explode('; ', $row[1]);
            $ret += $this->extracted2($pulls);
        }
        return (string)$ret;
    }

    /**
     * @param array<string> $pulls
     * @return bool
     */
    private function extracted(array $pulls): bool
    {
        foreach ($pulls as $pull) {
            $tot = ['red' => 12, 'green' => 13, 'blue' => 14];
            $dicesets = explode(', ', $pull);
            foreach ($dicesets as $diceset) {
                $dice = explode(' ', $diceset);
                $dice[0] = intval($dice[0]);
                if ($tot[$dice[1]] < $dice[0]) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * @param array<string> $pulls
     * @return int
     */
    private function extracted2(array $pulls): int
    {
        $tot = ['red' => 0, 'green' => 0, 'blue' => 0];
        foreach ($pulls as $pull) {
            $dicesets = explode(', ', $pull);
            foreach ($dicesets as $diceset) {
                list($nrOf,$color) = explode(' ', $diceset);
                $nrOf = intval($nrOf);
                if ($nrOf > $tot[$color]) {
                    $tot[$color] = $nrOf;
                }
            }
        }
        return array_product($tot);
    }
}
