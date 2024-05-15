<?php

declare(strict_types=1);

namespace App\Y2019;

use Phaoc\DayBase;
use Phaoc\DayInterface;
use App\Y2019\Helpers\ICCFactory;

class Day02 extends DayBase implements DayInterface
{
    /**
     * @return iterable<string>
     */
    public function testPart1(): iterable
    {
        yield '2' => '1,0,0,0,99';
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
        $input = $this->parseInput($input, ',');
        $C = ICCFactory::getICC($input);

        if (!$this->isTest) {
            $C->poke(1, 12);
            $C->poke(2, 2);
        }
        $C->run();
        return (string)$C->peek(0);
    }

    public function solvePart2(string $input): string
    {
        $input = $this->parseInput($input, ',');
        for ($i = 0; $i < 100; $i++) {
            for ($ii = 0; $ii < 100; $ii++) {
                $C = ICCFactory::getICC($input);
                $C->poke(1, $i);
                $C->poke(2, $ii);
                $C->run();
                if ($C->peek(0) == 19690720) {
                    return (string)((100 * $i) + $ii);
                }
            }
        }
        return '';
    }
}
