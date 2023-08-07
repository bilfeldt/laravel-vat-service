<?php

namespace Bilfeldt\VatService;

use Illuminate\Support\ServiceProvider;

class VatServiceServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfig();
    }

    public function boot()
    {
        $this->publishConfig();
    }

    private function mergeConfig()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/vat.php', 'vat');
    }

    private function publishConfig()
    {
        $this->publishes([
            __DIR__.'/../config/vat.php' => config_path('vat.php'),
        ], 'config');
    }
}