<?php

namespace App\Y2021\Helpers;

class Path2
{
    public string $next;
    /**
     * @var array<string>
     */
    public array $p;
    /**
     * @var mixed[]
     */
    public array $c;
    public bool $done = false;

    /**
     * @param array<string> $input
     */
    public function __construct(array $input)
    {
        $this->c = $input;
    }

    /**
     * @param array<string> $input
     * @param bool $extra
     * @return array<string, array<string, array<string, bool|int>|int|true>>
     */
    public static function parseInput(array $input, bool $extra = false): array
    {
        $connections = [];
        foreach ($input as $item) {
            [$from, $to] = explode('-', $item);
            $fromState = !($from == $extra);
            $toState = !($to == $extra);
            if (!isset($connections[$from])) {
                $connections[$from] = [
                    'v' => $from == strtoupper($from) ? true : 1,
                    'c' => []
                ];
            }
            if (!isset($connections[$to])) {
                $connections[$to] = [
                    'v' => $to == strtoupper($to) ? true : 1,
                    'c' => []
                ];
            }
            $connections[$from]['c'][$to] =& $connections[$to]['v'];
            $connections[$to]['c'][$from] =& $connections[$from]['v'];
        }
        return $connections;
    }

    /**
     * @return mixed>
     */
    public function moveToNext(): mixed
    {
        $this->p[] = $this->next;
        if (count($this->p) > 9 || $this->c[$this->next]['v'] <= 0) {
            print_r($this);
            die();
        }
        if ($this->next == 'end') {
            $this->done = true;
            return [];
        }
        $next = array_key_first($this->c[$this->next]['c']);
        $ret = [];
        foreach (array_slice(array_keys($this->c[$this->next]['c']), 1) as $key) {
            if ($this->c[$key]['v'] === true || $this->c[$key]['v'] > 0) {
                $P = clone($this);
                $P->next = $key;
                $ret[] = $P;
            }
        }
        if (!is_bool($this->c[$this->next]['v'])) {
            $this->c[$this->next]['v']--;
            if ($this->c[$this->next]['v'] == 0) {
                unset($this->c[$this->next]);
                foreach ($this->c as $key => $_) {
                    unset($this->c[$key]['c'][$this->next]);
                }
            }
        }
        if (is_string($next)) {
            $this->next = $next;
        } else {
            $this->done = true;
        }
        return $ret;
    }

    public function print(): void
    {
        echo Path2 . phpjoin(',', $this->p) . PHP_EOL;
    }
}
