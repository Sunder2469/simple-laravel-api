<?php

namespace App\Providers;

use App\Services\Currency\CurrencyFactory;
use Illuminate\Support\ServiceProvider;
use App\Services\Currency\{
    XmlDriver,
    JsonDriver,
    CsvDriver,
    AverageDriver
};

class CurrencyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('currency', function ($app) {
            $drivers = [
                'xml' => XmlDriver::class,
                'json' => JsonDriver::class,
                'csv' => CsvDriver::class,
                'average' => function () use ($app) {
                    return new AverageDriver([
                        $app->make(XmlDriver::class),
                        $app->make(JsonDriver::class),
                        $app->make(CsvDriver::class),
                    ]);
                }
            ];

            return new CurrencyFactory($drivers);
        });
    }
}
