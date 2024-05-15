<?php

namespace App\Y2019\Helpers;

use App\Y2019\Helpers\ICCInterface;

class ICCFactory
{
    private static string $icc = '\App\Event\Year2019\Helpers\IntCodeComputer';

    /**
     * @param $inputs
     * @return ICCInterface
     */
    public static function getICC($inputs): ICCInterface
    {
        // self::$icc = '\App\Event\Year2019\Helpers\AranIntCode';
        // self::$icc = '\App\Event\Year2019\Helpers\VuryssIntCode';
        self::$icc = '\App\Y2019\Helpers\ICC';
        return new self::$icc($inputs);
    }
}
