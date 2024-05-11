<?php

declare(strict_types=1);

namespace App\Y2020;

use Phaoc\DayBase;
use Phaoc\DayInterface;

class Day21 extends DayBase implements DayInterface
{
    /**
     * @return iterable<string>
     */
    public function testPart1(): iterable
    {
        yield '5' => 'mxmxvkd kfcds sqjhc nhms (contains dairy, fish)
trh fvjkl sbzzf mxmxvkd (contains dairy)
sqjhc fvjkl (contains soy)
sqjhc mxmxvkd sbzzf (contains fish)';
    }

    /**
     * @return iterable<string>
     */
    public function testPart2(): iterable
    {
        yield 'mxmxvkd,sqjhc,fvjkl' => 'mxmxvkd kfcds sqjhc nhms (contains dairy, fish)
trh fvjkl sbzzf mxmxvkd (contains dairy)
sqjhc fvjkl (contains soy)
sqjhc mxmxvkd sbzzf (contains fish)';
    }

    public function solvePart1(string $input): string
    {
        list($count, $allergens) = $this->parseIngredients($input);
        return (string)array_sum(array_diff_key(array_count_values($count), array_flip($allergens)));
    }

    public function solvePart2(string $input): string
    {
        $aler = $this->parseIngredients($input)[1];
        ksort($aler);
        return join(',', $aler);
    }

    private function parseIngredients(string $input): array
    {
        $input = $this->parseInput($input);
        $a = [];
        $count = [];

        foreach ($input as $row) {
            $p = explode(' (contains ', $row);
            $allergens = explode(', ', substr($p[1], 0, -1));
            $ingredients = explode(' ', $p[0]);
            $count = array_merge($count, $ingredients);
            foreach ($allergens as $allergen) {
                if (!isset($a[$allergen])) {
                    $a[$allergen] = array_flip($ingredients);
                } else {
                    $a[$allergen] = array_intersect_key($a[$allergen], array_flip($ingredients));
                }
            }
        }
        $aler = [];
        while (count($a)) {
            foreach ($a as $key => $val) {
                if (count($val) == 1) {
                    $aler[$key] = key($val);
                    unset($a[$key]);
                    foreach ($a as $rkey => $rval) {
                        if (isset($rval[$aler[$key]])) {
                            unset($a[$rkey][$aler[$key]]);
                        }
                    }
                }
            }
        }
        return array($count, $aler);
    }
}
