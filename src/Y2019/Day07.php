<?php

declare(strict_types=1);

namespace App\Y2019;

use Phaoc\DayBase;
use Phaoc\DayInterface;
use App\Y2019\Helpers\ICCFactory;
use App\Y2019\Helpers\ICCInterface;

class Day07 extends DayBase implements DayInterface
{
    /**
     * @return iterable<string>
     */
    public function testPart1(): iterable
    {
        yield '43210' => '3,15,3,16,1002,16,10,16,1,16,15,15,4,15,99,0,0';
        yield '54321' => '3,23,3,24,1002,24,10,24,1002,23,-1,23,101,5,23,23,1,24,23,23,4,23,99,0,0';
        yield '65210' => '3,31,3,32,1002,32,10,32,1001,31,-2,31,1007,31,0,33,1002,33,7,33,1,33,31,31,1,32,31,31,4,31,99,0,0,0';
    }

    /**
     * @return iterable<string>
     */
    public function testPart2(): iterable
    {
        yield '139629729' => '3,26,1001,26,-4,26,3,27,1002,27,2,27,1,27,26,27,4,27,1001,28,-1,28,1005,28,6,99,0,0,5';
        yield '18216' => '3,52,1001,52,-5,52,3,53,1,52,56,54,1007,54,5,55,1005,55,26,1001,54,-5,54,1105,1,12,1,53,54,53,1008,54,0,55,1001,55,1,55,2,53,55,53,4,53,1001,56,-1,56,1005,56,6,99,0,0,0,0,10';
    }

    public function solvePart1(string $input): string
    {
        $input = $this->parseInput($input, ',');
        $thrusterOutputs = [];
        foreach ($this->getUniqCombos(range(0, 4)) as $possibleInputs) {
            $output = 0;
            foreach ($possibleInputs as $possibleInput) {
                $output = (ICCFactory::getICC($input))->run([$possibleInput, $output]);
            }
            $thrusterOutputs[] = $output;
        }
        return (string)max($thrusterOutputs);
    }

    public function solvePart2(string $input): string
    {
        $input = $this->parseInput($input, ',');
        $thrusterOutputs = [];
        foreach ($this->getUniqCombos(range(5, 9)) as $possibleInputs) {
            $i = 0;
            $output = 0;
            /** @var ICCInterface[] $intcodeComputers */
            $intcodeComputers = [];
            while (true) {
                $loop = intdiv($i, 5);
                $computer = $i % 5;
                $intcodeComputers[$computer] ??= ICCFactory::getICC($input);
                $parameters = [$output];
                if ($loop === 0) {
                    $parameters = [$possibleInputs[$computer], $output];
                }
                $last_output = $intcodeComputers[$computer]->run($parameters);
                if ($last_output !== null) {
                    $output = $last_output;
                }
                if ($intcodeComputers[$computer]->completed()) {
                    $thrusterOutputs[] = $output;
                    break;
                }
                $i++;
            }
        }
        return (string)max($thrusterOutputs);
    }

    protected function getUniqCombos($items, $perms = []): array
    {
        if (empty($items)) {
            return [$perms];
        } else {
            $return = [];
            for ($i = count($items) - 1; $i >= 0; --$i) {
                $newitems = $items;
                $newperms = $perms;
                list($foo) = array_splice($newitems, $i, 1);
                array_unshift($newperms, $foo);
                $return = array_merge($return, $this->getUniqCombos($newitems, $newperms));
            }
            return $return;
        }
    }
}
