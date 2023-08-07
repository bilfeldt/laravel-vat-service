<?php

namespace Bilfeldt\VatService;

use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

interface VatServiceInterface
{
    /**
     * @param string $countryCode
     * @return Collection<string>
     */
    public function getFormats(string $countryCode): Collection;

    public function isValidFormat(string $countryCode, string $vatNumber): bool;

    public function isValid(string $countryCode, string $vatNumber): bool;

    /**
     * @param string $countryCode
     * @param string $vatNumber
     * @return void
     * @throws ValidationException
     */
    public function validate(string $countryCode, string $vatNumber): void;

    public function getInformation(string $countryCode, string $vatNumber): VatInformation;

    /**
     * @param string $countryCode
     * @param string $search
     * @return Collection<VatInformation>
     */
    public function search(string $countryCode, string $search): Collection;
}