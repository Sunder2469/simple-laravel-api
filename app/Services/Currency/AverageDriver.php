<?php

namespace App\Services\Currency;

class AverageDriver extends CurrencyDriver
{
    public function __construct(protected array $drivers)
    {
    }

    protected function fetchRate(string $currency): float
    {
        $rates = array_map(function ($driver) use ($currency) {
            return $driver->getRate($currency);
        }, $this->drivers);

        return array_sum($rates) / count($rates);
    }
}

