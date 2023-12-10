<?php

namespace App\Y2023\Helpler;

class Fooder
{
    const mapTypes = [
        'seed-to-soil',
        'soil-to-fertilizer',
        'fertilizer-to-water',
        'water-to-light',
        'light-to-temperature',
        'temperature-to-humidity',
        'humidity-to-location'
    ];
    /**
     * @var array<array<array<int>>>
     */
    private static array $maps = [];

    /**
     * @var array<int>
     */
    public static array $seeds = [];
    /**
     * @var array<int,int>
     */
    public static array $seeds2 = [];
    public static function getFromInput(string $input): void
    {
        $sections = explode("\n\n", chop($input));
        $seeds = array_shift($sections);
        self::$seeds = array_map('intval', explode(' ', substr($seeds, 7)));
        for ($i = 0; $i < count(self::$seeds); $i += 2) {
            $key = self::$seeds[$i];
            self::$seeds2[$key] = self::$seeds[$i + 1];
        }


        $i = 0;
        foreach ($sections as $section) {
            $rows = explode("\n", $section);
            $name = substr(array_shift($rows), 0, -5);
            foreach ($rows as $row) {
                list($destination,$source,$range) = explode(' ', $row);
                self::$maps[$name][] = [
                    'dest' => intval($destination),
                    'source' => intval($source),
                    'range' => intval($range)
                ];
            }
        }
    }

    public static function getDestFromMap(string $mapName, int $nr): int
    {
        foreach (self::$maps[$mapName] as $redir) {
            if ($nr >= $redir['source'] && $nr <= ($redir['source'] + $redir['range'] - 1)) {
                return $redir['dest'] - $redir['source'] + $nr;
            }
        }
        return $nr;
    }
}
