<?php

namespace App\Y2019\Helpers;

use App\Y2019\Helpers\ICCBase;
use App\Y2019\Helpers\ICCInterface;
use Exception;

class ICC extends ICCBase implements ICCInterface
{
    private array $numArgs = [1 => 3, 2 => 3, 3 => 1, 4 => 1, 5 => 2, 6 => 2, 7 => 3, 8 => 3, 9 => 1, 99 => 0];
    private array $posArgs = [1 => 3, 2 => 3, 3 => 1, 4 => -1, 5 => -1, 6 => -1, 7 => 3, 8 => 3, 9 => -1];

    private int $i = 0;

    private int $relPos = 0;
    private int $p = 0;
    /**
     * @var bool
     */
    private bool $completed = false;

    public function __construct(array $code)
    {
        $this->memory = $code;
    }

    public function run(array $inputs = []): ?int
    {
        while (true) {
            $this->i++;
            $a = str_pad((string)$this->memory[$this->p], 5, '0', STR_PAD_LEFT);
            $opCode = (int)($a[3] . $a[4]);
            $mode = [1 => (int)$a[2], 2 => (int)$a[1], 3 => (int)$a[0]];

            $arg = [];
            $this->getArgs($opCode, $mode, $arg);

            switch ($opCode) {
                case 1:
                    $this->memory[$arg[3]] = (int)$arg[1] + (int)$arg[2];
                    break;
                case 2:
                    $this->memory[$arg[3]] = (int)$arg[1] * (int)$arg[2];
                    break;
                case 3:
                    $this->memory[$arg[1]] = array_shift($inputs);
                    break;
                case 4:
                    $this->p += $this->numArgs[$opCode] + 1;
                    $this->lastOutput = (int)$arg[1];
                    return $this->lastOutput;
                case 5:
                    if ($arg[1] !== 0) {
                        $this->p = $arg[2] - ($this->numArgs[$opCode] + 1);
                        break;
                    }
                    break;
                case 6:
                    if ($arg[1] === 0) {
                        $this->p = $arg[2] - ($this->numArgs[$opCode] + 1);
                    }
                    break;
                case 7:
                    $this->memory[$arg[3]] = $arg[1] < $arg[2] ? 1 : 0;
                    break;
                case 8:
                    $this->memory[$arg[3]] = $arg[1] === $arg[2] ? 1 : 0;
                    break;
                case 9;
                    $this->relPos += $arg[1];
                    break;
                case 99:
                    $this->completed = true;
                    return null;
                default:
                    die('No opCode: ' . $opCode);
            }
            $this->p += $this->numArgs[$opCode] + 1;
        }
    }

    public function completed(): bool
    {
        return $this->completed;
    }

    /**
     * @param int $opCode
     * @param array $mode
     * @param array $arg
     */
    private function getArgs(int $opCode, array $mode, array &$arg): void
    {
        try {
            for ($i = 1; $i <= $this->numArgs[$opCode]; $i++) {
                $value = (int)$this->memory[$this->p + $i];
                if ($this->posArgs[$opCode] === $i) {
                    $arg[$i] = $mode[$i] === 2 ? $this->relPos + $value : $value;
                } elseif ($mode[$i] === 0) {
                    $arg[$i] = (int)($this->memory[$value] ?? 0);
                } elseif ($mode[$i] === 1) {
                    $arg[$i] = $value;
                } else {
                    $arg[$i] = (int)($this->memory[$this->relPos + $value] ?? 0);
                }
            }
        } catch (Exception $e) {
            var_dump($opCode);
            echo "Loop: " . $this->i . PHP_EOL;
            echo $this->memDump(true) . PHP_EOL;
            die();
        }
    }
}
