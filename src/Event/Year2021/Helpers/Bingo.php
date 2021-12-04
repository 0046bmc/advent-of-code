<?php

namespace App\Event\Year2021\Helpers;

// 23072 to low
class Bingo
{
    public array $cards=[];
    private array $nrs;

    public function __construct(array $input)
    {
        $this->nrs = explode(",", $input[0]);
        $nrOfCards = floor(count($input) / 6);
        $cardId = 0;
        for ($i = 0; $i < $nrOfCards; $i++) {
            $offset = 2 + ($i * 6);
            foreach (array_slice($input, $offset, 5) as $key => $row) {
                $this->cards[$cardId][$key] = sscanf($row,'%d %d %d %d %d');
            }
            $cardId++;
        }
    }

    public function check(): string
    {
        foreach ($this->nrs as $currNr) {
            foreach ($this->cards as $cardNr => $crd) {
                $res = $this->markNrOnCard($currNr, $cardNr);
                if ($res) {
                    $return = array();
                    array_walk_recursive(
                        $this->cards[$cardNr],
                        function ($a) use (&$return) {
                            $return[] = $a;
                        }
                    );
                    unset($this->cards[$cardNr]);
                    return strval(array_sum($return) * $currNr);
                }
            }
        }

        return '';
    }

    /**
     * @param mixed $currNr
     * @param int $cardNr
     */
    private function markNrOnCard(mixed $currNr, int $cardNr): bool
    {
        $dtat = $this->findNr($currNr, $this->cards[$cardNr]);
        if ($dtat == null) {
            return false;
        }
        unset($this->cards[$cardNr][$dtat[0]][$dtat[1]]);
        $countRow = count($this->cards[$cardNr][$dtat[0]]);
        $countCol = count(array_column($this->cards[$cardNr], $dtat[1]));
        if ($countRow == 0 || $countCol == 0) {
            return true;
        }
        return false;
    }

    private function findNr($sNr, $array)
    {
        foreach ($array as $rowId => $col) {
            foreach ($col as $colId => $nr) {
                if ($nr == $sNr) {
                    return [$rowId, $colId];
                }
            }
        }
    }

}