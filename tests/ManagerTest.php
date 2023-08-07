<?php

namespace Bilfeldt\VatService\Tests;

use Bilfeldt\VatService\VatServiceManager;

class ManagerTest extends TestCase
{
    public function test_resolves_default_driver(): void
    {
        config()->set('vat.default', 'foo');

        $driver = resolve(VatServiceManager::class)->getDefaultDriver();

        $this->assertEquals('foo', $driver);
    }
}