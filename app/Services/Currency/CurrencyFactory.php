<?php

namespace App\Services\Currency;

class CurrencyFactory
{
    public function __construct(protected array $drivers)
    {
    }

    public function make(string $driver): CurrencyDriver
    {
        if (!isset($this->drivers[$driver])) {
            throw new \InvalidArgumentException("Driver [{$driver}] not supported.");
        }

        return app($this->drivers[$driver]);
    }
}
