<?php

declare(strict_types=1);

namespace App\Y2020;

use Phaoc\DayBase;
use Phaoc\DayInterface;
use App\Y2020\Helpers\DoublyLL;

class Day23 extends DayBase implements DayInterface
{
    private static bool $debug = false;
    private static int $step = 0;
    /**
     * @return iterable<string>
     */
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

    /**
     * @return iterable<string>
     */
    public function testPart2(): iterable
    {
        //        yield '149245887792' => '389125467'; // Comment out for faster test
        return [];
    }

    public function solvePart1(string $input): string
    {
        $input = array_map('intval', str_split(chop($input)));

        self::$debug = true;
        $res = $this->cupGame($input);
        self::$step = 0;
        $pointer = array_search(1, $res);
        $this->printCups($res, $pointer);
        $this->moveView($res, $pointer, min($res), 1);
        array_shift($res);
        return join('', $res);
    }

    public function solvePart2(string $input): string
    {
        return '';
        $input = array_map('intval', str_split(chop($input)));

        $C = $this->doPlay($input, 10000000, 1000000);
        $gc = $C->getSliceKeys(1, 3);

        return (string)($gc[1] * $gc[2]);
    }

    /**
     * @param array<int> $input
     * @param int $loops
     * @param int $fill
     * @return DoublyLL
     */
    private function doPlay(array $input, int $loops, int $fill = 0): DoublyLL
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

    private function cupGame(array $input)
    {
        $lowest = min($input);
        $pointer = 0;
        $nrOf = count($input);
        for ($i = 1; $i <= 100; $i++) {
            self::$step = $i;
            self::debug('-- move ' . $i . ' --' . ' pos: ' . ($pointer + 1));
            $this->moveView($input, $pointer, $lowest, $i);

            $choosen = $input[$pointer];

            $this->printCups($input, $pointer);

            $nrOf = count($input);
            $pickupStart = ($pointer + 1) % $nrOf;
            $pickupEnd = ($pickupStart + 3) % $nrOf;

            if ($pickupStart < $pickupEnd) {
                $pickup = array_splice($input, $pickupStart, 3);
            } else {
                $pickup = array_splice($input, $pickupStart);
                $pickup = array_merge($pickup, array_splice($input, 0, $pickupEnd));
            }

            self::debug('pick up: ' . join(', ', $pickup));

            $newChoosen = $choosen;
            $dest = false;
            do {
                $newChoosen--;
                if ($newChoosen < $lowest) {
                    $newChoosen = max($input);
                }
                $dest = array_search($newChoosen, $input);
            } while ($dest === false);

            self::debug('Destination: ' . $input[$dest]);

            $before = array_slice($input, 0, $dest + 1);
            $after = array_slice($input, $dest + 1);
            $input = array_merge(
                $before,
                $pickup,
                $after
            );
            $pointer = array_search($choosen, $input) + 1;
            if ($pointer >= count($input)) {
                $pointer = 0;
            }
            self::debug('');
        }
        return $input;
    }

    private function printCups(array $input, int $pointer): void
    {
        if (!self::$debug || self::$step > 7) {
            return;
        }
        echo 'cups: ';
        foreach ($input as $i => $cup) {
            if ($i === $pointer) {
                echo '(' . $cup . ')';
            } else {
                echo ' ' . $cup . ' ';
            }
        }
        echo PHP_EOL;
    }

    private function moveView(array &$input, int &$pointer, int $lowest, int $i): void
    {
        $nrOf = count($input);
        if ($i % $nrOf < $pointer + 1) {
            $steps = $pointer + 1 - $i % $nrOf;
            self::debug('Move counter clocwise ' . $steps . ' steps');
            $input = $this->moveArrayClockwise($input, $steps);
            $pointer = ($nrOf + $pointer - $steps) % $nrOf;
        } elseif ($i % $nrOf > $pointer + 1) {
            $steps = $i % $nrOf - $pointer - 1;
            self::debug('Move counter clocwise ' . $steps . ' steps');
            $input = $this->moveArrayCounterClockwise($input, $steps);
            $pointer = ($pointer + $steps) % $nrOf;
        }
    }
    private function moveArrayClockwise(array $input, int $steps): array
    {
        $moving = array_splice($input, 0, $steps);
        return array_merge($input, $moving);
    }
    private function moveArrayCounterClockwise(array $input, int $steps): array
    {
        $moving = array_splice($input, -$steps);
        return array_merge($moving, $input);
    }
    private static function debug(string $message): void
    {
        if (self::$debug && self::$step <= 7) {
            echo $message . PHP_EOL;
        }
    }
}
