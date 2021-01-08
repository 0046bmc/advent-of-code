<?php

namespace mahlstrom;

use Exception;

abstract class MapBase
{
    protected function checkPosCount($pos,$nr){
        if(count($pos)!=$nr){
            throw new Exception('Number of arguments in pos not matching: '.$nr);
        }
    }
}