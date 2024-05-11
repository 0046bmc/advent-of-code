<?php

namespace App\Y2020\Helpers;

class Ticket
{
    private static array $raw = [];
    private static array $fields = [];

    public static function parseTickets($input)
    {
        preg_match("/(.*)\n\nyour ticket:\n(.*)\n\nnearby tickets:\n(.*)/s", $input, $m);
        self::$raw['fields'] = $m[1];
        self::$raw['my'] = $m[2];
        self::$raw['nearby'] = $m[3];
    }

    public static function getSumIll(): int
    {
        $nb = self::getNearBy();
        $lg = [];
        preg_match_all('/(\d+-\d+) or (\d+-\d+)/', self::$raw['fields'], $m);
        foreach ($m as $d) {
            foreach ($d as $r) {
                $n = explode('-', $r);
                for ($i = $n[0]; $i <= $n[1]; $i++) {
                    $lg[] = $i;
                }
            }
        }
        $nbNr = [];
        array_walk_recursive(
            $nb,
            function ($nb) use (&$nbNr) {
                $nbNr[] = $nb;
            }
        );

        return array_sum(array_diff($nbNr, $lg));
    }

    public static function get2()
    {
        $fields = self::getFields();
        $valid = self::getValidTickets($fields);
        $myTicket = explode(',', self::$raw['my']);
        $valid = array_merge($valid, [$myTicket]);
        $match = [];
        for ($i = 0; $i < count($valid[0]); $i++) {
            foreach (self::$fields as $fkey => $fval) {
                if (count(array_diff(array_column($valid, $i), $fval)) == 0) {
                    $match[$i][] = $fkey;
                }
            }
        }
        $mField = [];
        while (count($match)) {
            foreach ($match as $col => $field) {
                if (count($field) == 1) {
                    $foundKey = array_shift($field);
                    $mField[$foundKey] = $col;
                    foreach ($match as $cc => $ff) {
                        unset($match[$cc][array_search($foundKey, $match[$cc])]);
                        if (count($match[$cc]) == 0) {
                            unset($match[$cc]);
                        }
                    }
                    break;
                }
            }
        }
        $ret = 1;
        foreach ($mField as $field => $col) {
            if (preg_match('/^departure/', $field)) {
                $ret = $ret * $myTicket[$col];
            }
        }
        return $ret;
    }

    /**
     * @return array
     */
    private static function getNearBy(): array
    {
        $tickets = [];
        foreach (explode("\n", self::$raw['nearby']) as $t) {
            $tt = array_map('intval', explode(',', $t));
            $tickets[] = $tt;
        }
        return $tickets;
    }

    private static function getFields()
    {
        preg_match_all('/([a-z0-9 ]*): (\d+-\d+) or (\d+-\d+)/s', self::$raw['fields'], $m);
        $fields = [];
        foreach ($m[1] as $i => $key) {
            $fields[$key][] = $f1 = explode('-', $m[2][$i]);
            $fields[$key][] = $f2 = explode('-', $m[3][$i]);
            for ($i = $f1[0]; $i <= $f1[1]; $i++) {
                self::$fields[$key][] = $i;
            }
            for ($i = $f2[0]; $i <= $f2[1]; $i++) {
                self::$fields[$key][] = $i;
            }
        }
        return $fields;
    }

    private static function getValidTickets($fields)
    {
        $nrs = self::getValidNumbers($fields);
        $ret = [];
        $t = self::getNearBy();
        foreach ($t as $key => $val) {
            if (!count(array_diff($val, $nrs))) {
                $ret[] = $val;
            }
        }
        return $ret;
    }

    /**
     * @param $fields
     * @return array
     */
    private static function getValidNumbers($fields): array
    {
        $nrs = [];
        foreach ($fields as $n) {
            foreach ($n as $nn) {
                for ($i = $nn[0]; $i <= $nn[1]; $i++) {
                    $nrs[] = $i;
                }
            }
        }
        return $nrs;
    }
}
