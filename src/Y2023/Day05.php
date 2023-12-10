<?php

declare(strict_types=1);

namespace App\Y2023;

use Phaoc\DayBase;
use Phaoc\DayInterface;
use App\Y2023\Helpler\Fooder;

class Day05 extends DayBase implements DayInterface
{
    /**
     * @return iterable<string>
     */
    public function testPart1(): iterable
    {
        yield '35' => file_get_contents(__DIR__ . '/Inputs/day05.test1.txt');
    }

    /**
     * @return iterable<string>
     */
    public function testPart2(): iterable
    {
        yield '46' => file_get_contents(__DIR__ . '/Inputs/day05.test1.txt');
    }

    public function solvePart1(string $input): string
    {
        $lowest = 9223372036854775807;
        Fooder::getFromInput($input);
        foreach (Fooder::$seeds as $nr) {
            $location = $this->getLocation($nr);
#            echo ' - Seed number ' . $nr . ' corresponds to soil number ' . $soil . PHP_EOL;
            if ($lowest > $location) {
                $lowest = $location;
            }
        }
        return (string)$lowest;
    }

    public function solvePart2(string $input): string
    {
        $lowest = 9223372036854775807;
        Fooder::getFromInput($input);
        $i = 1;
        $tot = count(Fooder::$seeds2);
        foreach (Fooder::$seeds2 as $seedStart => $seedRange) {
            $c = $seedStart;
            $stop = $seedStart + $seedRange;
            echo $i . '/' . $tot . PHP_EOL;
            for ($nr = $seedStart; $nr < ($seedStart + $seedRange); $nr++) {
                echo $stop - $nr . PHP_EOL;
                $location = $this->getLocation($nr);
                if ($lowest > $location) {
                    $lowest = $location;
                }
            }
            $i++;
        }
        return (string)$lowest;
    }

    /**
     * @param mixed $nr
     * @return mixed
     */
    private function getLocation(mixed $nr): mixed
    {
        $soil = Fooder::getDestFromMap('seed-to-soil', $nr);
        $fertilizer = Fooder::getDestFromMap('soil-to-fertilizer', $soil);
        $water = Fooder::getDestFromMap('fertilizer-to-water', $fertilizer);
        $light = Fooder::getDestFromMap('water-to-light', $water);
        $temperature = Fooder::getDestFromMap('light-to-temperature', $light);
        $humidity = Fooder::getDestFromMap('temperature-to-humidity', $temperature);
        $location = Fooder::getDestFromMap('humidity-to-location', $humidity);
        return $location;
    }
}
