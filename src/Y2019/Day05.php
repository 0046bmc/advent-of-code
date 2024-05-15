<?php

declare(strict_types=1);

namespace App\Y2019;

use Phaoc\DayBase;
use Phaoc\DayInterface;
use App\Y2019\Helpers\ICCFactory;

class Day05 extends DayBase implements DayInterface
{
    /**
     * @return iterable<string>
     */
    public function testPart1(): iterable
    {
        yield '0' => '1002,4,3,4,33';
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
        $ret = false;
        while ($ret !== null) {
            $ret = $C->run([1]);
        }
        return (string)$C->getLastOutput();
    }

    public function solvePart2(string $input): string
    {
        $input = $this->parseInput($input, ',');
        return (string)(ICCFactory::getICC($input))->run([5]);
    }
}
