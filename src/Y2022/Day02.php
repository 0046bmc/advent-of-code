<?php

declare(strict_types=1);

namespace App\Y2022;

use Phaoc\DayBase;
use Phaoc\DayInterface;
use App\Y2022\Helpers\RPS;

class Day02 extends DayBase implements DayInterface
{
    /**
     * @var array|string[]
     */
    private array $conv = [
        'X' => 'A',
        'Y' => 'B',
        'Z' => 'C'
    ];

    /**
     * @return iterable<string>
     */
    public function testPart1(): iterable
    {
        yield '15' => 'A Y
B X
C Z';
    }

    /**
     * @return iterable<string>
     */
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
            $G->doRound($p1, $this->conv[$p2]);
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
                    $G->doRound($p1, $p1);
                    break;
                case 'BZ':
                case 'AX':
                    $G->doRound($p1, 'C');
                    break;
                case 'CX':
                case 'AZ':
                    $G->doRound($p1, 'B');
                    break;
                case 'CZ':
                case 'BX':
                    $G->doRound($p1, 'A');
                    break;
            }
        }
        return (string)$G->p2;
    }
}
