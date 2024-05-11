<?php

namespace App\Y2020\Helpers;

use ArrayAccess;
use Iterator;

class DoublyLL extends SuperBase2
{
    protected bool $loop = true;

    public function play($i)
    {
//        echo '-- move ' . $i . ' --' . PHP_EOL;
//        $this->printit();
//        echo PHP_EOL;
        $nextPos = $this->getNextOffset();

        $pickup = $this->getSliceKeys($nextPos, 3);
//        echo 'pick up: ' . join(', ', $b) . PHP_EOL;
        $dest = $this->current() - 1;
        while (in_array($dest, $pickup) || $dest < 1) {
            $dest--;
            if ($dest < 1) {
                $dest = $this->max();
            }
        }
//        echo 'destination: ' . $dest . PHP_EOL . PHP_EOL;

        $this->moveSlice($nextPos, 3, $dest);

        $this->next();
        if (!$this->valid()) {
            echo "Rewind";
            $this->rewind();
        }
    }

    public function moveSlice($index, $length, $dest)
    {
        $pickup = $this->getSliceKeys($index, 3);
        $this->cups[$this->pos]->next = $this->cups[$pickup[2]]->next;
        $this->cups[$pickup[2]]->next = $this->cups[$dest]->next;
        $this->cups[$dest]->next = $this->cups[$pickup[0]]->value;
    }

    public function printit()
    {
        $key = $this->first;
        $row1 = 'cups: ';
        $row2 = 'prev: ';
        $row3 = 'next: ';
        do {
            if ($key == $this->current()) {
                $row1 .= '(' . $this->offsetGet($key) . ')';
            } else {
                $row1 .= ' ' . $this->offsetGet($key) . ' ';
            }
            $row2 .= ' ' . $this->cups[$key]->prev . ' ';
            $row3 .= ' ' . $this->cups[$key]->next . ' ';

            $key = $this->cups[$key]->next;
        } while ($key != $this->first);
        echo chop($row1) . PHP_EOL;
        echo chop($row2) . PHP_EOL;
        echo chop($row3) . PHP_EOL;
    }
}
