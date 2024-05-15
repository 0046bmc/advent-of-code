<?php

declare(strict_types=1);

namespace App\Y2019;

use Phaoc\DayBase;
use Phaoc\DayInterface;
use App\Y2019\Helpers\OrbitMap;

class Day06 extends DayBase implements DayInterface
{
    /**
     * @return iterable<string>
     */
    public function testPart1(): iterable
    {
        yield '42' => 'COM)B
B)C
C)D
D)E
E)F
B)G
G)H
D)I
E)J
J)K
K)L';
    }

    /**
     * @return iterable<string>
     */
    public function testPart2(): iterable
    {
        yield '4' => 'COM)B
B)C
C)D
D)E
E)F
B)G
G)H
D)I
E)J
J)K
K)L
K)YOU
I)SAN';
    }

    public function solvePart1(string $input): string
    {
        $input = $this->parseInput($input);
        $O = new OrbitMap($input);
        return (string)$O->countOrbits();
    }

    public function solvePart2(string $input): string
    {
        $input = $this->parseInput($input);
        $O = new OrbitMap($input);
        return (string)$O->countTransfers('YOU', 'SAN');
    }
}
