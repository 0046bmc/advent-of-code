<?php

declare(strict_types=1);

namespace App\Y2018;

use Phaoc\DayBase;
use Phaoc\DayInterface;
use DateTime;
use Exception;
use App\Y2018\Helpers\Guard;

class Day04 extends DayBase implements DayInterface
{
    /**
     * @return iterable<string>
     */
    public function testPart1(): iterable
    {
        yield '240' => $this->getTestInput();
    }

    /**
     * @return iterable<string>
     */
    public function testPart2(): iterable
    {
        yield '4455' => $this->getTestInput();
//         yield '4455' => '[1518-11-01 00:00] Guard #10 begins shift
// [1518-11-01 00:25] wakes up
// [1518-11-01 00:55] wakes up
// [1518-11-01 23:58] Guard #99 begins shift
// [1518-11-02 00:50] wakes up
// [1518-11-03 00:05] Guard #10 begins shift
// [1518-11-03 00:29] wakes up
// [1518-11-04 00:02] Guard #99 begins shift
// [1518-11-01 00:30] falls asleep
// [1518-11-02 00:40] falls asleep
// [1518-11-03 00:24] falls asleep
// [1518-11-01 00:05] falls asleep
// [1518-11-04 00:36] falls asleep
// [1518-11-05 00:45] falls asleep
// [1518-11-04 00:46] wakes up
// [1518-11-05 00:03] Guard #99 begins shift
// [1518-11-05 00:55] wakes up';
    }

    public function solvePart1(string $input): string
    {
        $events = $this->parseTimes($input);
        $g = $this->parseGuardSleep($events);

        $hi = new Guard(-1);
        foreach ($g as $gid => $s) {
            if ($s->slept > $hi->slept) {
                $hi = $s;
            }
        }
        echo $hi->id . ' * ' . $hi->hiMinute() . PHP_EOL;
        return (string)($hi->id * $hi->hiMinute());
    }

    public function solvePart2(string $input): string
    {
        $events = $this->parseTimes($input);
        $g = $this->parseGuardSleep($events);
        $hi = new Guard(-1);
        foreach ($g as $gid => $s) {
            if ($s->freq() > $hi->freq()) {
                $hi = $s;
            }
        }
        return (string)($hi->id * $hi->hiMinute());
    }

    /**
     * @param string $input
     * @param $ar
     * @param array $events
     * @return array
     */
    public function parseTimes(string $input): array
    {
        $events = [];
        $input = $this->parseInput($input);
        foreach ($input as $row) {
            if (preg_match('/^\[([0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2})] (.*)/', $row, $ar)) {
                $events[$ar[1]] = $ar[2];
            } else {
                var_dump($row);
                exit();
            }
        }
        ksort($events);
        return $events;
    }

    /**
     * @param array $events
     * @param $ar
     * @return Guard[]
     * @throws Exception
     */
    public function parseGuardSleep(array $events): array
    {
        $sleep = null;
        $guard = null;
        $g = [];
        foreach ($events as $dt => $e) {
            if (preg_match('/ #(\d*) /', $e, $ar)) {
                if ($sleep !== null) {
                    die('wrong');
                }
                $guard = $ar[1];
                $sleep = null;
            } elseif (strstr($e, 'falls asleep')) {
                $sleep = $dt;
            } elseif (strstr($e, 'wakes up')) {
                $end = new DateTime($dt);
                $start = new DateTime($sleep);
                $diff = $start->diff($end);
                if (!isset($g[$guard])) {
                    $g[$guard] = new Guard(intval($guard));
                }
                $g[$guard]->sleep($start, $end);
                $sleep = null;
            }
        }
        return $g;
    }
}
