<?php

namespace App\Services\Currency;

use Illuminate\Support\Facades\Cache;

abstract class CurrencyDriver
{
    abstract protected function fetchRate(string $currency): float;

    public function getRate(string $currency): float
    {
        return Cache::remember($this->getCacheKey($currency), 300, function () use ($currency) {
            return $this->fetchRate($currency);
        });
    }

    protected function getCacheKey(string $currency): string
    {
        return "currency_rate_{$currency}_" . static::class;
    }

    public function clearCache(string $currency): void
    {
        Cache::forget($this->getCacheKey($currency));
    }
}
