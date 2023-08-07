<?php

namespace Bilfeldt\VatService\Tests;

use Bilfeldt\VatService\VatServiceServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            VatServiceServiceProvider::class,
        ];
    }
}
