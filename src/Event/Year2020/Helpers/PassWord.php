<?php

namespace App\Event\Year2020\Helpers;

use Exception;
use JetBrains\PhpStorm\Pure;

class PassWord
{
    public int $no1;
    public int $no2;
    public string $check;
    public string $pass;

    public function __construct($string)
    {
        try {
            if (!preg_match('/(\d*)-(\d*) ([a-z]): ([a-z]*)/', $string, $ar)) {
                die('`' . $string . '` does not match preg_match in class `Password` on line: ' . (__LINE__ - 1) . PHP_EOL);
            }

            $this->no1 = intval($ar[1]);
            $this->no2 = intval($ar[2]);
            $this->check = $ar[3];
            $this->pass = $ar[4];
        } catch (Exception $e) {
            print_r($e);
            die('wro');
        }
    }

    #[Pure] public function isMinMax(): bool
    {
        $o = substr_count($this->pass, $this->check);
        if ($o >= $this->no1 && $o <= $this->no2) {
            return true;
        }
        return false;
    }

    #[Pure] public function isOneOf(): bool
    {
        if (
            substr_compare($this->pass, $this->check, ($this->no1 - 1), 1) xor
            substr_compare($this->pass, $this->check, ($this->no2 - 1), 1)
        ) {
            return true;
        }
        return false;
    }
}
