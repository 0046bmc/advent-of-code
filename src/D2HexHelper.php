<?php

namespace mahlstrom;

class D2HexHelper
{
    public static function getCoordsDir(int $x, int $y, mixed $dir, $sep = false): string|array
    {
        switch ($dir) {
            case 'se':
                $x += ($y % 2 == 0) ? 1 : 0;
                $y += 1;
                break;
            case 'sw':
                $x -= ($y % 2 == 0) ? 0 : 1;
                $y += 1;
                break;
            case 'ne':
                $x += ($y % 2 == 0) ? 1 : 0;
                $y -= 1;
                break;
            case 'nw':
                $x -= ($y % 2 == 0) ? 0 : 1;
                $y -= 1;
                break;
            case 'e':
                $y -= 0;
                $x += 1;
                break;
            case 'w':
                $y -= 0;
                $x -= 1;
                break;
            default:
                echo $dir . ' not exists';
                exit();
        }
        if ($sep) {
            return array($x, $y);
        } else {
            return join(',', [$x, $y]);
        }
    }
}