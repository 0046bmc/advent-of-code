<?php

declare(strict_types=1);

namespace App\Event\Year2020;

use AdventOfCode\DayBase;
use AdventOfCode\DayInterface;
use App\Event\Year2020\Helpers\CupCircle;
use App\Event\Year2020\Helpers\DoublyLL;

class Day23 extends DayBase implements DayInterface
{
    public function testPart1(): iterable
    {
//        yield '92658374' => '389125467'; // 10
//        yield '92637458' => '389125467'; // 11
//        yield '37458926' => '389125467'; // 12
//        yield '64937258' => '389125467'; // 20
//        yield '35298467' => '389125467'; // 30
//        yield '65497238' => '389125467'; // 40
        yield '67384529' => '389125467'; // 100
    }

    public function testPart2(): iterable
    {
//        yield '149245887792' => '389125467'; // Comment out for faster test
        return [];
    }

    public function solvePart1(string $input): string
    {
        $input = array_map('intval', str_split(chop($input)));

        $C = $this->doPlay($input, 100);
        $C->printit();
        echo join(', ', $C->getEm(1)) . PHP_EOL;
        return substr(join('', $C->getEm(1)), 1);
    }

    private function doPlay(array $input, int $loops, int $fill = 0): CupCircle|DoublyLL
    {
        $C = new DoublyLL();

        $x = [];
        if ($fill > max($input)) {
            $x = range(max($input) + 1, $fill);
        }
        foreach ($input as $n) {
            $C->add($n, $n);
        }
        foreach ($x as $n) {
            $C->add($n, $n);
        }

        $i = 1;
        while ($i <= $loops) {
            $nextPos = $C->getNextOffset();
            $pickup = $C->getSliceKeys($nextPos, 3);
            $dest = $C->current() - 1;
            while (in_array($dest, $pickup) || $dest < 1) {
                $dest--;
                if ($dest < 1) {
                    $dest = $C->max();
                }
            }
            $C->moveSlice($nextPos, 3, $dest);
            $C->next();
            $i++;
        }
        return $C;
    }

    public function solvePart2(string $input): string
    {
        $input = array_map('intval', str_split(chop($input)));

        $C = $this->doPlay($input, 10000000, 1000000);
        $gc = $C->getSliceKeys(1, 3);

        return (string)($gc[1] * $gc[2]);
    }

}
