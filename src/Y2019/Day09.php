<?php

declare(strict_types=1);

namespace App\Y2019;

use Phaoc\DayBase;
use Phaoc\DayInterface;
use App\Y2019\Helpers\ICCFactory;

class Day09 extends DayBase implements DayInterface
{
    /**
     * @return iterable<string>
     */
    public function testPart1(): iterable
    {
        yield '109' => '109,1,204,-1,1001,100,1,100,1008,100,16,101,1006,101,0,99';
        yield '1219070632396864' => '1102,34915192,34915192,7,4,7,99,0';
        yield '1125899906842624' => '104,1125899906842624,99';
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
        if ($this->isTest) {
            return (string)$C->run();
        } else {
            while (!$C->completed()) {
                $C->run([1]);
            }
        }
        return (string)$C->getLastOutput();
    }

    public function solvePart2(string $input): string
    {
        $input = $this->parseInput($input, ',');
        $C = ICCFactory::getICC($input);
        while (!$C->completed()) {
            $C->run([2]);
        }
        return (string)$C->getLastOutput();
    }
}
