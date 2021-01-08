<?php

namespace mahlstrom;

interface MapInterface
{
    function checkMinMax($plane,int $min,int $max);
    function cleanUp();
    function print($nr);
    function getNeighborCoords(int ...$pos);
}