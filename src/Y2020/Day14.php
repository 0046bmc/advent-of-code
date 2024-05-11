<?php

declare(strict_types=1);

namespace App\Y2020;

use Phaoc\DayBase;
use Phaoc\DayInterface;

class Day14 extends DayBase implements DayInterface
{
    /**
     * @return iterable<string>
     */
    public function testPart1(): iterable
    {
        yield '165' => 'mask = XXXXXXXXXXXXXXXXXXXXXXXXXXXXX1XXXX0X
mem[8] = 11
mem[7] = 101
mem[8] = 0';
    }

    /**
     * @return iterable<string>
     */
    public function testPart2(): iterable
    {
        yield '208' => 'mask = 000000000000000000000000000000X1001X
mem[42] = 100
mask = 00000000000000000000000000000000X0XX
mem[26] = 1';
    }

    public function solvePart1(string $input): string
    {
        $input = $this->parseInput($input);
        $mem = [];
        $mask = '';
        foreach ($input as $cmdLine) {
            list($cmd, $val) = explode(' = ', $cmdLine);
            if ($cmd == 'mask') {
                $mask = strrev($val);
                continue;
            }
            $pos = preg_replace('/mem\[(\d)\]/', '$1', $cmd);
            $newVal = $this->doMask(intval($val), $mask);
            $mem[$pos] = $newVal;
        }
        return (string)array_sum($mem);
    }

    public function solvePart2(string $input): string
    {
        $input = $this->parseInput($input);
        foreach ($input as $cmdLine) {
            list($cmd, $val) = explode(' = ', $cmdLine);
            if ($cmd == 'mask') {
                $mask = $val;
                continue;
            }
            $pos = intval(substr($cmd, 4, -1));
            $posAr = $this->inToMaskArray($mask, intval($pos));
            foreach ($posAr as $poz) {
                $mem[$poz] = intval($val);
            }
        }
        return (string) array_sum($mem);
    }

    private function doMask(int $int, string $rMask): float|int
    {
        $v = decbin($int);
        $rv = strrev($v);
        $ss = '';
        foreach (str_split($rMask) as $key => $chr) {
            if ($chr == 'X') {
                $ss .= (isset($rv[$key])) ? $rv[$key] : 0;
                continue;
            } else {
                $ss .= $chr;
            }
        }
        $res = bindec(strrev($ss));
        return $res;
    }

    private function inToMaskArray(string $mask, int $pos): array
    {
        $len = strlen($mask);
        $posb = str_pad(decbin($pos), $len, '0', STR_PAD_LEFT);
        $rets = [''];
        for ($i = $len - 1; $i >= 0; $i--) {
            switch ($mask[$i]) {
                case '1':
                    foreach (array_keys($rets) as $key) {
                        $rets[$key] = '1' . $rets[$key];
                    }
                    break;
                case 'X':
                    $new = [];
                    foreach (array_keys($rets) as $key) {
                        $new[] = '0' . $rets[$key];
                        $new[] = '1' . $rets[$key];
                    }
                    $rets = $new;
                    break;
                default:
                    foreach (array_keys($rets) as $key) {
                        $rets[$key] = $posb[$i] . $rets[$key];
                    }
            }
        }
        foreach ($rets as $key => $rr) {
            $rets[$key] = bindec($rr);
        }
        return $rets;
    }
}
