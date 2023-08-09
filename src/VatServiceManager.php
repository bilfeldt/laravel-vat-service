<?php

namespace Bilfeldt\VatService;

use Illuminate\Support\Collection;
use Illuminate\Support\Manager;

class VatServiceManager extends Manager implements VatServiceInterface
{
    public function getDefaultDriver(): string
    {
        return $this->config->get('vat.default');
    }

    public function getFormats(string $countryCode): Collection
    {
        return $this->driver()->getFormats($countryCode);
    }

    public function isValidFormat(string $countryCode, string $vatNumber): bool
    {
        return $this->driver()->isValidFormat($countryCode, $vatNumber);
    }

    public function isValid(string $countryCode, string $vatNumber): bool
    {
        return $this->driver()->isValid($countryCode, $vatNumber);
    }

    public function validate(string $countryCode, string $vatNumber): void
    {
        $this->driver()->validate($countryCode, $vatNumber);
    }

    public function getInformation(string $countryCode, string $vatNumber): VatInformation
    {
        return $this->driver()->getInformation($countryCode, $vatNumber);
    }

    public function search(string $countryCode, string $search): Collection
    {
        return $this->driver()->search($countryCode, $search);
    }

    public function driver($driver = null): VatServiceInterface
    {
        return parent::driver($driver);
    }
}
