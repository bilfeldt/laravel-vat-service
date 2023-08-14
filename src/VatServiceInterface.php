<?php

namespace Bilfeldt\VatService;

use Bilfeldt\VatService\Exceptions\InvalidVatException;
use Bilfeldt\VatService\Exceptions\UnsupportedCountryException;
use Bilfeldt\VatService\Exceptions\VatNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

interface VatServiceInterface
{
    public static function supports(string $countryCode): bool;

    /**
     * Get the possible formats for the given country code.
     *
     * A star (*) means any number or letter while a hash (#)
     * means any number and a question mark (?) means any letter.
     *
     * @param string $countryCode
     * @return Collection<string>
     */
    public function getFormats(string $countryCode): Collection;

    /**
     * @param string $countryCode
     * @param string $vatNumber
     * @return bool
     */
    public function isValidFormat(string $countryCode, string $vatNumber): bool;

    /**
     * Check if the VAT number has correct format and if so, check if it exists.
     *
     * This endpoint will often require an external API request.
     *
     * @param string $countryCode
     * @param string $vatNumber
     * @return bool
     * @throws VatNotFoundException
     */
    public function isValid(string $countryCode, string $vatNumber): bool;

    /**
     * @param string $countryCode
     * @param string $vatNumber
     * @return void
     * @throws ValidationException
     */
    public function validate(string $countryCode, string $vatNumber): void;

    /**
     * @param string $countryCode
     * @param string $vatNumber
     * @return VatInformation
     * @throws VatNotFoundException
     * @throws InvalidVatException
     */
    public function getInformation(string $countryCode, string $vatNumber): VatInformation;

    /**
     * @param string $countryCode
     * @param string $search
     * @return Collection<VatInformation>
     */
    public function search(string $countryCode, string $search): Collection;
}