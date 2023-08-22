<?php

namespace Bilfeldt\VatService\Tests;

use Bilfeldt\VatService\Drivers\CvrApi;
use Illuminate\Support\Facades\Http;
use Bilfeldt\VatService\VatInformation;
use Bilfeldt\VatService\VatServiceManager;
class CvrApiTest extends TestCase
{
    protected CvrApi $driver;

    public function setup(): void
    {
        parent::setup();
        $this->driver = resolve(VatServiceManager::class)->driver('cvr_api');
    }

    public function test_resolves_correct_driver(): void
    {
        $this->assertInstanceOf(CvrApi::class, $this->driver);
    }

    public function test_support_returns_true()
    {
        $this->assertTrue(
            $this->driver->supports('DK')
        );
        $this->assertTrue(
            $this->driver->supports('NO')
        );
    }

    public function test_details_return_vat_information_object()
    {
        Http::fake([
            'cvrapi.dk/*' => Http::response(
                file_get_contents(__DIR__ . '/Fixtures/CvrApi/search-by-vat-number-response.json'),
                200
            ),
        ]);

        $vatInfo = $this->driver->getInformation('DK', '29910251');
        $this->assertInstanceOf(
            VatInformation::class,
            $vatInfo,
        );
        $this->assertEquals('DK', $vatInfo->country);
        $this->assertEquals('29910251', $vatInfo->vatNumber);
        $this->assertEquals('I/S Just Iversen', $vatInfo->company);
        $this->assertEquals('Jonsvangen 10', $vatInfo->address);
        $this->assertEquals('4200', $vatInfo->postalCode);
        $this->assertEquals('Slagelse', $vatInfo->city);
        $this->assertEquals('61401169', $vatInfo->phone);
        $this->assertEquals('kontakt@justiversen.dk', $vatInfo->email);
    }

    public function test_is_valid_returns_true()
    {
        Http::fake([
            'cvrapi.dk/*' => Http::response(
                file_get_contents(__DIR__ . '/Fixtures/CvrApi/search-by-vat-number-response.json'),
                200
            ),
        ]);

        $this->assertTrue(
            $this->driver->isValid('DK', '12345678')
        );
    }

    public function test_is_valid_returns_false()
    {
        Http::fake([
            'cvrapi.dk/*' => Http::response(
                [
                    "error" => "NOT_FOUND",
                    "t" => 0,
                    "version" => 6,
                ],
                404
            ),
        ]);

        $this->assertFalse(
            $this->driver->isValid('DK', '12345678')
        );
    }
}
