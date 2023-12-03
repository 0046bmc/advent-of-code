<?php

declare(strict_types=1);

namespace App\Event\Year2021;

use App\AoC\DayBase;
use App\AoC\DayInterface;
use App\Event\Year2021\Helpers\Path;
use App\Event\Year2021\Helpers\Path2;

class Day12 extends DayBase implements DayInterface
{
    private $paths = [];

    public function testPart1(): iterable
    {
        yield '10' => 'start-A
start-b
A-c
A-b
b-d
A-end
b-end';
        yield '19' => 'dc-end
HN-start
start-kj
dc-start
dc-HN
LN-dc
HN-end
kj-sa
kj-HN
kj-dc';
        yield '226' => 'fs-end
he-DX
fs-he
start-DX
pj-DX
end-zg
zg-sl
zg-pj
pj-he
RW-he
fs-DX
pj-RW
zg-RW
start-pj
he-WI
zg-he
pj-fs
start-RW';
    }

    public function testPart2(): iterable
    {
        yield '36' => 'start-A
start-b
A-c
A-b
b-d
A-end
b-end';
    }

    public function solvePart1(string $input): string
    {
        $input = $this->parseInput($input);
        $c = Path2::parseInput($input);
        $Ot = new Path2($c);
        $Ot->next = 'start';
        $all = [$Ot];
        while (count($all)) {
            $O = array_pop($all);
            if ($O->done) {
                continue;
            }
            while ($O->done !== true) {
                $all = array_merge($all, $O->moveToNext());
#                $O->print();
            }
            echo 'Res: ';
#            $O->print();
            echo "---" . PHP_EOL;
            sleep(3);
        }
#        exit();
        $connections = $this->getConnections($input);
        $P = new Path($connections);
        $P->curr = 'start';
        $cons = [$P];

        $ends = $this->countPaths($cons);
        return (string)$ends;
    }

    /**
     * @param array $input
     * @param bool $extra
     * @return array
     */
    private function getConnections(array $input, bool $extra = false): array
    {
        $connections = [];
        foreach ($input as $item) {
            [$from, $to] = explode('-', $item);
            $fromState = !($from == $extra);
            $toState = !($to == $extra);
            if (!isset($connections[$from])) {
                $connections[$from] = [$to => $fromState];
            } else {
                $connections[$from][$to] = $fromState;
            }
            if (!isset($connections[$to])) {
                $connections[$to] = [$from => $toState];
            } else {
                $connections[$to][$from] = $toState;
            }
        }
        return $connections;
    }

    /**
     * @param Path[] $cons
     * @return int
     */
    private function countPaths(array $cons): int
    {
        $ends = 0;
        $finales = [];
        while (count($cons)) {
            $P = array_pop($cons);
            if ($P->done === true) {
                if (end($P->p) == 'end') {
                    $ends++;
                    $finales[] = join(',', $P->p);
                }
                continue;
            }
            while (true) {
                $cons = array_merge($cons, $P->getSiblings());
                $res = $P->moveForward();
                if (!$res) {
                    break;
                }
            }
            if (end($P->p) == 'end') {
                $ends++;
                $finales[] = join(',', $P->p);
            }
        }
        sort($finales);
        $finales = array_unique($finales);
        sort($finales);
        //print_r($finales);
        return count($finales);
    }

    public function solvePart2(string $input): string
    {
//        exit();
        $input = $this->parseInput($input);
        $connectionz = $this->getConnections($input);
        $cons = [];
        foreach (array_keys($connectionz) as $key) {
            if (!in_array($key, ['start', 'end']) && $key == strtolower($key)) {
                $connections = $this->getConnections($input, $key);
                $P = new Path($connections);
                $P->curr = 'start';
                $cons[] = $P;
            }
        }

        $ends = $this->countPaths($cons);
        return (string)$ends;
    }
}
