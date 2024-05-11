<?php

declare(strict_types=1);

namespace App\Y2020;

use Phaoc\DayBase;
use Phaoc\DayInterface;
use App\Y2020\Helpers\PassWord;
use Exception;

class Day02 extends DayBase implements DayInterface
{
    /**
     * @return iterable<string>
     */
    public function testPart1(): iterable
    {
        yield '2' => $this->getTestInput();
    }

    /**
     * @return iterable<string>
     */
    public function testPart2(): iterable
    {
        yield '1' => $this->getTestInput();
    }

    public function solvePart1(string $input): string
    {
        $input = $this->parseInput($input);
        $minmax = 0;
        foreach ($input as $r) {
            try {
                $pass = new PassWord($r);
                if ($pass->isMinMax()) {
                    $minmax++;
                }
            } catch (Exception $e) {
                var_dump($e);
                exit(1);
            }
        }
        return (string)$minmax;
    }

    public function solvePart2(string $input): string
    {
        $input = $this->parseInput($input);
        $oneis = 0;
        foreach ($input as $r) {
            try {
                $pass = new PassWord($r);
                if ($pass->isOneOf()) {
                    $oneis++;
                }
            } catch (Exception $e) {
                var_dump($e);
                exit(1);
            }
        }
        return (string)$oneis;
    }
}
