<?php

namespace App\Y2020\Helpers;

use ArrayObject as ArGrej;

class ACC2
{
    public ArGrej $M;
    public int $acc = 0;

    public function __construct(string $input)
    {
        $this->M = self::codeParser($input);
    }

    public function run(): bool
    {
        $posC = [];
        $it = $this->M->getIterator();
        while ($it->valid()) {
            if (!isset($posC[$it->key()])) {
                $posC[$it->key()] = 1;
            } else {
                return false;
            }

            list($cmd, $val) = $it->current();
            $key = $it->key();
//            echo sprintf('%s[%s]: %s => %s','ACC2',$key,$cmd,$val).PHP_EOL;
            switch ($cmd) {
                case 'acc':
                    $this->acc += intval($val);
                    break;
                case 'jmp':
                    $it->seek($key + intval($val) - 1);
                    break;
            }
            $it->next();
        }
        return true;
    }

    public static function codeParser(string $data): ArGrej
    {
        $ar = explode("\n", chop($data));
        $a = new ArGrej();
        foreach ($ar as $i => $row) {
            $a[$i] = explode(' ', $row);
        }
        return $a;
    }
}
