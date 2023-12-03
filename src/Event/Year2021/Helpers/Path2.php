<?php

namespace App\Event\Year2021\Helpers;

class Path2
{
    public string $next;
    public array $p;
    public array $c;
    public bool $done = false;

    public function __construct($input)
    {
        $this->c = $input;
    }

    public static function parseInput(array $input, $extra = false)
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

    public function moveToNext()
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

    public function getSiblings()
    {
//        foreach (array_slice($this->c['c'],1) as $key=>$val){
//
//        }
    }

    public function print()
    {
        echo join(',', $this->p) . PHP_EOL;
    }
}
