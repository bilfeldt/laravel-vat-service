<?php

namespace Bilfeldt\VatService\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Bilfeldt\VatService\VatServiceServiceProvider;
use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            VatServiceServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function defineEnvironment($app)
    {
        $app->useEnvironmentPath(__DIR__.'/..');
        $app->bootstrapWith([LoadEnvironmentVariables::class]);
        parent::getEnvironmentSetUp($app);
        $app['config']->set('vat.drivers.cvr_api.user_agent', env('VAT_CVR_API_USER_AGENT'));
    }
}
