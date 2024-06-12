<?php

namespace App\Services\Currency;

class CsvDriver extends CurrencyDriver
{
    protected function fetchRate(string $currency): float
    {
        // Fetch rate from XML file
        // Implementation here
    }
}

