<?php

declare(strict_types=1);

namespace App\Event\Year2022;

use mahlstrom\AoC\DayBase;
use mahlstrom\AoC\DayInterface;
use mahlstrom\AoC\Year2022\Helpers\RPS;

class Day02 extends DayBase implements DayInterface
{
    private array $conv = [
        'X' => 'A',
        'Y' => 'B',
        'Z' => 'C'
    ];

    public function testPart1(): iterable
    {
        yield '15' => 'A Y
B X
C Z';
    }

    public function testPart2(): iterable
    {
        yield '12' => 'A Y
B X
C Z';
    }

    public function solvePart1(string $input): string
    {
        $G = new RPS();
        $input = $this->parseInput($input);
        foreach ($input as $row) {
            list($p1, $p2) = explode(' ', $row);
            $G->do_round($p1, $this->conv[$p2]);
        }
        return (string)$G->p2;
    }

    public function solvePart2(string $input): string
    {
        $G = new RPS();
        $input = $this->parseInput($input);
        foreach ($input as $row) {
            list($p1, $p2) = explode(' ', $row);
            switch ($p1 . $p2) {
                case 'CY':
                case 'BY':
                case 'AY':
                    $G->do_round($p1, $p1);
                    break;
                case 'BZ':
                case 'AX':
                    $G->do_round($p1, 'C');
                    break;
                case 'CX':
                case 'AZ':
                    $G->do_round($p1, 'B');
                    break;
                case 'CZ':
                case 'BX':
                    $G->do_round($p1, 'A');
                    break;
            }
        }
        return (string)$G->p2;
    }

}
