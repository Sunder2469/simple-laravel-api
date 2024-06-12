<?php

if (!function_exists('convertCurrency')) {
    function convertCurrency($amount, $currency): float|int
    {
        $driver = config('currency.default_driver', 'average');
        $rate = \App\Facades\CurrencyFacade::make($driver)->getRate($currency);
        return $amount * $rate;
    }
}
