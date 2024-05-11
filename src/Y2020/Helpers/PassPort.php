<?php

namespace App\Y2020\Helpers;

class PassPort
{
    public string $byr;// (Birth Year)
    public string $iyr;// (Issue Year)
    public string $eyr;// (Expiration Year)
    public string $hgt;// (Height)
    public string $hcl;// (Hair Color)
    public string $ecl;// (Eye Color)
    public string $pid;// (Passport ID)
    public string $cid;// (Country ID)

    public function __construct()
    {
    }

    public function set($key, $val)
    {
        $this->$key = $val;
    }

    public function isValid(): bool
    {
        $no = 0;
        $req = [
            'byr',
            'iyr',
            'eyr',
            'hgt',
            'hcl',
            'ecl',
            'pid',
            //'cid'
        ];
        foreach ($req as $key) {
            if (isset($this->$key)) {
                $no++;
            }
        }
        if ((count($req) - $no) <= 0) {
            return true;
        }
        return false;
    }

    public function isRealValid(): bool
    {
        if (
            /* byr */ $this->yearCheck($this->byr, 1920, 2002) &&
            /* iyr */ $this->yearCheck($this->iyr, 2010, 2020) &&
            /* eyr */ $this->yearCheck($this->eyr, 2020, 2030) &&
            /* hgt */ $this->heightCheck($this->hgt) &&
            /* hcl */ $this->hairCheck($this->hcl) &&
            /* ecl */ $this->eyeCheck($this->ecl) &&
            /* pid */ $this->pidCheck($this->pid)
        ) {
            return true;
        } else {
            return false;
        }
    }

    private function yearCheck($val, $min, $max): bool
    {
        if (
            preg_match('/^\d{4}$/', $val, $ar)
            && $val >= $min
            && $val <= $max
        ) {
            return true;
        }
        return false;
    }

    private function heightCheck($hgt): bool
    {
        if (preg_match('/^(\d*)(cm|in)$/', $hgt, $ar)) {
            if ($ar[2] == 'cm' && $ar[1] >= 150 && $ar[1] <= 193) {
                return true;
            }
            if ($ar[2] == 'in' && $ar[1] >= 59 && $ar[1] <= 76) {
                return true;
            }
            return false;
        }
        return false;
    }

    private function hairCheck($hcl): bool
    {
        if (preg_match('/^#[0-9a-f]{6}$/', $hcl, $ar)) {
            return true;
        }
        return false;
    }

    private function eyeCheck($ecl): bool
    {
        if (in_array($ecl, ['amb', 'blu', 'brn', 'gry', 'grn', 'hzl', 'oth'])) {
            return true;
        }
        return false;
    }

    private function pidCheck($pid): bool
    {
        return (bool)preg_match('/^[0-9]{9}$/', $pid);
    }
}
