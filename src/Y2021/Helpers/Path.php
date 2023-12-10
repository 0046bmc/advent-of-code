<?php

namespace App\Y2021\Helpers;

class Path
{
    public array $p = [];
    public string $curr;
    public bool $done = false;

    public function __construct(public array $connections)
    {
    }

    public function getSiblings(): array
    {
        $ret = [];
        foreach (array_slice(array_keys($this->connections[$this->curr]), 1) as $key) {
            $P = clone($this);
            $P->moveForward($key);
            $ret[] = $P;
        }
        return $ret;
    }

    public function moveForward($key = false): bool
    {
        $this->p[] = $this->curr;
        if (!$key) {
            $key = array_key_first($this->connections[$this->curr]);
        }
        if (!is_string($key)) {
            return false;
        }
        if ($key == 'end') {
            $this->p[] = 'end';
            $this->done = true;
            return false;
        }
        if ($this->curr == strtolower($this->curr)) {
            foreach ($this->connections as $kkey => $_) {
                if (isset($this->connections[$kkey][$this->curr])) {
                    if ($this->connections[$kkey][$this->curr] === true) {
                        unset($this->connections[$kkey][$this->curr]);
                    } else {
                        $this->connections[$kkey][$this->curr] = true;
                    }
                }
            }
        }
        $this->curr = $key;
        return true;
    }
}
