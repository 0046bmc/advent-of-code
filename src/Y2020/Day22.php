<?php

declare(strict_types=1);

namespace App\Y2020;

use Phaoc\DayBase;
use Phaoc\DayInterface;

class Day22 extends DayBase implements DayInterface
{
    private int $iLimit = PHP_INT_MAX - 1;
    private int $lvl = 0;
    private int $llvl = -1;
    private int $gc = 0;
    private array $sublvls = [
        0 => 0,
        1 => 0,
        2 => 0,
        3 => 0,
        4 => 0,
        5 => 0,
        6 => 0,
        7 => 0,
        8 => 0,
        9 => 0,
        10 => 0,
        11 => 0,
        12 => 0,
        13 => 0,
        14 => 0,
        15 => 0,
        16 => 0,
        17 => 0,
        18 => 0,
        19 => 0,
    ];
    /**
     * @return iterable<string>
     */
    public function testPart1(): iterable
    {
        yield '306' => 'Player 1:
9
2
6
3
1

Player 2:
5
8
4
7
10';
    }

    /**
     * @return iterable<string>
     */
    public function testPart2(): iterable
    {
//        yield '273' => 'Player 1:
//43
//19
//
//Player 2:
//2
//29
//14';
        yield '291' => 'Player 1:
9
2
6
3
1

Player 2:
5
8
4
7
10';
    }

    public function solvePart1(string $input): string
    {
        list($p1, $p2) = $this->dealCards($input);

        $this->combat($p1, $p2);
        if (count($p1)) {
            $sum = $this->calcSum($p1);
        } else {
            $sum = $this->calcSum($p2);
        }
        return (string)$sum;
    }

    public function solvePart2(string $input): string
    {
        // Not right 34772 low
        list($p1, $p2) = $this->dealCards($input);

        $winner = $this->recursiveCombat($p1, $p2);
        if ($winner == 1) {
            $sum = $this->calcSum($p1);
        } else {
            $sum = $this->calcSum($p2);
        }
        return (string)$sum;
    }

    /**
     * @param string $input
     * @return array
     */
    private function dealCards(string $input): array
    {
        [$p1, $p2] = explode("\n\n", $input);
        $p1 = array_map('intval', explode("\n", chop($p1)));
        array_shift($p1);
        $p2 = array_map('intval', explode("\n", chop($p2)));
        array_shift($p2);
        return array($p1, $p2);
    }

    private function combat(array &$p1, array &$p2): void
    {
        $i = 1;
        while (count($p1) && count($p2) && $i < $this->iLimit) {
//            echo sprintf('-- Round %s --', $i) . PHP_EOL;
//            echo "Player 1's deck: " . join(', ', $p1) . PHP_EOL;
//            echo "Player 2's deck: " . join(', ', $p2) . PHP_EOL;
            $pc1 = array_shift($p1);
            $pc2 = array_shift($p2);

//            echo "Player 1 plays: " . $pc1 . PHP_EOL;
//            echo "Player 2 plays: " . $pc2 . PHP_EOL;
            if ($pc1 > $pc2) {
                $p1[] = $pc1;
                $p1[] = $pc2;
//                echo "Player 1 wins the round!" . PHP_EOL;
            } elseif ($pc1 < $pc2) {
                $p2[] = $pc2;
                $p2[] = $pc1;
//                echo "Player 2 wins the round!" . PHP_EOL;
            } else {
                die('YATT??');
            }
//            echo PHP_EOL;
            $i++;
        }
    }

    public function calcSum($p)
    {
        $i = 1;
        $sum = 0;
        foreach (array_reverse($p) as $nr) {
//            echo $nr . '*' . $i . PHP_EOL;
            $sum += ($nr * $i);
            $i++;
        }
        return $sum;
    }

    /**
     * @param array|bool $p1
     * @param array|bool $p2
     */
    private function recursiveCombat(array &$p1, array &$p2, int $gameNr = 1): int
    {
        $this->gc++;
        $this->lvl++;
        $org = $this->gc;
        $this->debug(sprintf('=== Game %s ===', $org) . PHP_EOL . PHP_EOL, $gameNr, $org);
        $p1Decks = [];
        $i = 1;
        while (count($p1) && count($p2) && $i < $this->iLimit) {
            if ($this->lvl != $this->llvl) {
                //      echo str_repeat(' ',$this->lvl).$this->lvl . PHP_EOL;
                $this->llvl = $this->lvl;
                $this->sublvls[$this->lvl]++;

                foreach ($this->sublvls as $key => $val) {
                    $this->debug2($key . ': ' . $val . '  ', $gameNr);
                }
                $this->debug2(PHP_EOL, $gameNr);
            } else {
                $this->debug(PHP_EOL, $gameNr, $org);
            }
            $p1string = join(', ', $p1);
            $p2string = join(', ', $p2);
            $winner = false;
            $this->debug(sprintf('-- Round %s (Game %s) --', $i, $org) . PHP_EOL, $gameNr, $org);
            $this->debug("Player 1's deck: " . $p1string . PHP_EOL, $gameNr, $org);
            $this->debug("Player 2's deck: " . join(', ', $p2) . PHP_EOL, $gameNr, $org);
            if (isset($p1Decks[$p1string])) {
                $winner = true;
                $pc1 = array_shift($p1);
                $pc2 = array_shift($p2);
            } elseif (isset($p2Decks[$p2string])) {
                $winner = true;
                $pc1 = array_shift($p1);
                $pc2 = array_shift($p2);
            } else {
                $p1Decks[$p1string] = true;
                $p2Decks[$p2string] = true;
                $pc1 = array_shift($p1);
                $pc2 = array_shift($p2);
                $this->debug("Player 1 plays: " . $pc1 . PHP_EOL, $gameNr, $org);
                $this->debug("Player 2 plays: " . $pc2 . PHP_EOL, $gameNr, $org);
                $xtra = '';
                if ($pc1 <= count($p1) && $pc2 <= count($p2)) {
                    $eP1 = array_slice($p1, 0, $pc1 + 1);
                    $eP2 = array_slice($p2, 0, $pc2 + 1);
                    $this->debug('Playing a sub-game to determine the winner...' . PHP_EOL . PHP_EOL, $gameNr, $org);
                    $winner = $this->recursiveCombat($eP1, $eP2, $gameNr);
                    $this->debug(sprintf(PHP_EOL . '...anyway, back to game %s.', $org) . PHP_EOL, $gameNr, $org);
                    $xtra = PHP_EOL;
                } else {
                    $winner = ($pc1 > $pc2) ? 1 : 2;
                }
            }
            $this->debug(
                sprintf("Player %s wins round %s of game %s!", $winner, $i, $org) . $xtra . PHP_EOL,
                $gameNr,
                $org
            );

            if ($winner == 1) {
                $p1[] = $pc1;
                $p1[] = $pc2;
            } else {
                $p2[] = $pc2;
                $p2[] = $pc1;
            }
            $i++;
        }
        $this->lvl--;
        $this->debug(sprintf('The winner of game %s is player %s!', $org, $winner) . PHP_EOL, $gameNr, $org);
        if (count($p1)) {
            return 1;
        } else {
            return 2;
        }
    }

    private function debug($string, $i, $org)
    {
        if ($i % 100090000 == 0) {
            echo $string;
        }
    }

    private function debug2($string, $i)
    {
        if ($i % 10000 == 0) {
            echo $string;
        }
    }
}
