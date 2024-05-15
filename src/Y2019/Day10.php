<?php

declare(strict_types=1);

namespace App\Y2019;

use Phaoc\DayBase;
use Phaoc\DayInterface;

class Day10 extends DayBase implements DayInterface
{
    /**
     * @return iterable<string>
     */
    public function testPart1(): iterable
    {
        yield '8' => $this->getTestInput();
        // yield '33' => $this->getTestInput(2);
        // yield '35' => $this->getTestInput(3);
        // yield '41' => $this->getTestInput(4);
        // yield '210' => $this->getTestInput(5);
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
        $input = $this->parseInput($input);
        $map = [];
        $positions = [];
        foreach ($input as $y => $line) {
            foreach (str_split($line) as $x => $item) {
                if ($item === '#') {
                    $map[$x][$y] = $item;
                }
            }
        }
        foreach ($map as $x => $yLine) {
            foreach ($yLine as $y => $item) {
                $positions[$x . '.' . $y] = count($this->findAstroidsInSight($map, $x, $y));
            }
        }
        $data = (int)max($positions);
        echo array_search($data, $positions) . PHP_EOL;
        return (string)$data;
    }

    public function solvePart2(string $input): string
    {
        $input = $this->parseInput($input);
        return '';
    }

    private function findAstroidsInSight(array $map, int $x, int $y): array
    {
        $angles = [];
        foreach ($map as $x1 => $yLine) {
            foreach ($yLine as $y1 => $item) {
                if ($x1 === $x && $y1 === $y) {
                    continue;
                }
                $angles[(string)atan2($y - $y1, $x1 - $x)] = true;
                if ($x === 3 && $y === 4) {
                    echo $x1 . ' ' . $y1 . ' ' . atan2($y - $y1, $x1 - $x) . PHP_EOL;
                }
            }
        }
        return $angles;
    }
}
