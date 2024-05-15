<?php

namespace App\Y2019\Helpers;

interface ICCInterface
{
    public function __construct(array $code);
    public function run(array $inputs = []);
    public function completed();
    public function peek(int $addr);
    public function poke(int $addr, int $value);
    public function memDump($join_dump = false);
    public function getLastOutput(): int;
}
