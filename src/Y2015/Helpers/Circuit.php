<?php

namespace App\Y2015\Helpers;

use \Exception;

class Circuit
{
    /**
     * @var array<int>
     */
    public array $wires;
    /**
     * @var array<string>
     */
    private array $queue;
    private ?int $is_second_part;

    /**
     * @param array<string> $input
     * @param null|int $is_second_part
     */
    public function __construct(array $input, int $is_second_part = null)
    {
        $this->is_second_part = $is_second_part;
        foreach ($input as $line) {
            if ($line != '') {
                $this->queue[] = trim($line);
            }
        }
        $this->etch();
    }

    private function etch(): void
    {
        while (count($this->queue)) {
            $num2 = false;
            $line = array_shift($this->queue);
            list($a, $op, $b, $out) = $this->parseLine($line);
            try {
                $num = $this->getNum($a);
            } catch (\Exception $e) {
                $this->queue[] = $line;
                continue;
            }
            if (in_array($op, ['AND', 'OR', 'LSHIFT', 'RSHIFT'])) {
                try {
                    $num2 = $this->getNum($b);
                } catch (\Exception $e) {
                    $this->queue[] = $line;
                    continue;
                }
            }
            $this->wires[$out] = match ($op) {
                'AND' => $num & $num2,
                'OR' => $num | $num2,
                'LSHIFT' => $num << $num2,
                'RSHIFT' => $num >> $num2,
                'NOT' => ~$num & 0xFFFF,
                'SET' => $this->is_second_part && $out == 'b' ? $this->is_second_part : $num,
                default => die('Not a valid operator')
            };
        }
    }

    /**
     * @param string $line
     * @return mixed[]
     * @throws \Exception
     */
    private function parseLine(string $line): array
    {
        if (preg_match('/^([\w]+) -> ([\w]+)$/', $line, $match) === 1) {
            $a = $match[1];
            $out = $match[2];
            $op = 'SET';
            $b = null;
        } elseif (preg_match('/^([\w]+) (AND|OR|LSHIFT|RSHIFT) ([\w]+) -> ([\w]+)$/', $line, $match) === 1) {
            $a = $match[1];
            $op = $match[2];
            $b = $match[3];
            $out = $match[4];
        } elseif (preg_match('/^(NOT) ([\w]+) -> ([\w]+)$/i', $line, $match) === 1) {
            $op = $match[1];
            $a = $match[2];
            $out = $match[3];
            $b = null;
        } else {
            throw new \Exception("parse error");
        }

        return [$a, $op, $b, $out];
    }

    private function getNum(string | int $var): int
    {
        if (is_numeric($var)) {
            return $var & 0xFFFF;
        }

        if (isset($this->wires[$var])) {
            return $this->wires[$var];
        }
        throw new Exception('Not in yet');
    }
}
