<?php

namespace App\Y2019\Helpers;

class OrbitMap
{
    public array $or = [];
    public array $or2 = [];

    public function __construct(array $rows)
    {
        foreach ($rows as $row) {
            $data = explode(')', $row);
            $key = $data[0];
            $key2 = chop($data[1]);
            $this->or[$key][] = $key2;
            $this->or2[$key2] = $key;
        }
    }

    public function countOrbits(): int
    {
        $p = ['COM'];
        $i = 0;
        $tot = 0;
        while (true) {
            $i++;

            $ar = [];
            foreach ($p as $key) {
                foreach ($this->or[$key] as $nkey) {
                    $tot += $i;
                    if (array_key_exists($nkey, $this->or)) {
                        $ar[] = $nkey;
                    }
                }
            }
            $p = $ar;
            if (!count($ar)) {
                break;
            }
        }
        return $tot;
    }

    public function countTransfers(string $from, string $to): bool|int|string|null
    {
        $youp = $this->getPathToOrbit($from);
        $sanp = $this->getPathToOrbit($to);
        return $this->getTransfersBetweenPaths($youp, $sanp);
    }

    private function getPathToOrbit($e): array
    {
        $path = [];
        while ($e != 'COM') {
            if (!array_key_exists($e, $this->or2)) {
                print_r($this->or2);
                echo $e . ' does not exist';
                exit();
            }

            $n = $this->or2[$e];
            $path[] = $this->or2[$e];
            $e = $n;
        }
        return $path;
    }

    private function getTransfersBetweenPaths($youp, $sanp): bool | int | string | null
    {
        foreach ($youp as $O) {
            if (in_array($O, $sanp)) {
                $sp = array_search($O, $sanp);
                $yp = array_search($O, $youp);
                return $sp + $yp;
            }
        }
        return null;
    }
}
