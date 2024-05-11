<?php

namespace App\Y2020\Helpers;

class ACC
{
    private int $p;
    public int $acc;
    public function __construct(private array $code)
    {
    }

    public function run(): bool
    {
        $this->p = 0;
        $this->acc = 0;
        $posC = [];
        while (true) {
            if (!isset($posC[$this->p])) {
                $posC[$this->p] = 1;
            } else {
                return false;
            }
            $inc = 1;
            preg_match('/^(...) (.\d*)$/', $this->code[$this->p], $ar);
//            echo sprintf('%s[%s]: %s => %s','ACC1',$this->p,$ar[1],$ar[2]).PHP_EOL;
            switch ($ar[1]) {
                case 'acc':
                    $this->acc += intval($ar[2]);
                    break;
                case 'jmp':
                    $this->p += intval($ar[2]);
                    $inc = 0;
                    break;
                case 'nop':
                    break;
            }
            $this->p += $inc;
            if ($this->p == count($this->code)) {
                return true;
            }
        }
    }
}
