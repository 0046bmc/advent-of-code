<?php

namespace App\Event\Year2020\Helpers;

class WierdCalc
{
    public static bool $debug = false;
    public static bool $hardcore = false;

    public function calc($s): int
    {
        while (($start = strpos($s, '(')) !== false) {
            $in = 1;
            $end = 1;
            $sub = '';
            while ($in > 0) {
                $in += match ($s[$start + $end]) {
                    '(' => 1,
                    ')' => -1,
                    default => 0
                };
                $sub .= $s[$start + $end];
                $end++;
            }
            $presS = substr($s, 0, $start);
            $omidS = substr($s, $start, $end);
            $postS = substr($s, $start + $end);

            self::debug($presS, nl: false, color: 202);
            self::debug($omidS, nl: false, color: 82);
            self::debug($postS, nl: true, color: 202);

            $re = $this->calc(substr($sub, 0, -1));
            self::debug($presS, nl: false, color: 202);
            self::debug($re, nl: false, color: 82);
            self::debug($postS, nl: true, color: 202);

            $s = $presS . $re . $postS;
        }
        if (self::$hardcore) {
            while (preg_match('/(\d*)\+(\d*)/', $s, $m)) {
                $s = preg_replace('/(\d*)\+(\d*)/', ($m[1] + $m[2]), $s, 1);
                self::debug($s, 7);
            }
            while (preg_match('/(\d*)\*(\d*)/', $s, $m)) {
                $s = preg_replace('/(\d*)\*(\d*)/', ($m[1] * $m[2]), $s, 1);
                self::debug($s, 7);
            }
        } else {
            while (preg_match('/[*+]/', $s)) {
                preg_match('/^(\d+)([*+-\/])(\d*)/', $s, $m);
                if (!isset($m[3]) || $m[3] == "" || !isset($m[1]) || $m[1] == "") {
                    echo 'WHAAA!!!' . PHP_EOL;
                    exit();
                }
                $a = match ($m[2]) {
                    '*' => ($m[1] * $m[3]),
                    '+' => ($m[1] + $m[3]),
                };
                $s = $a . substr($s, strlen($m[0]));
                self::debug($s, 7);
            }
        }
        return intval($s);
    }

    private static function debug(mixed $d, $color = 82, $nl = true)
    {
        if (self::$debug) {
            echo "\e[40;38;5;" . $color . "m" . $d . "\e[0m";
            if ($nl) {
                echo PHP_EOL;
            }
        }
    }
}