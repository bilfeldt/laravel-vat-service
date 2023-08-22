<?php

namespace Bilfeldt\VatService\Drivers;

use Bilfeldt\VatService\Exceptions\DriverUnavailable;
use Bilfeldt\VatService\Exceptions\InvalidVatException;
use Bilfeldt\VatService\Exceptions\UnsupportedCountryException;
use Bilfeldt\VatService\Exceptions\VatNotFoundException;
use Bilfeldt\VatService\VatInformation;
use Bilfeldt\VatService\VatServiceInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use InvalidArgumentException;

class CvrApi implements VatServiceInterface
{
    private static array $formats = [
        'DK' => [
            '########'
        ],
        'NO' => [
            // empty means any format is accepted
        ],
    ];

    public static function supports(string $countryCode): bool
    {
        return array_key_exists(strtoupper($countryCode), self::$formats);
    }

    public function __construct(
        private ?string $accessToken, // This api actually works without an access token, but then rate limiting is applied.
    ) {}

    /** @inheritDoc */
    public function getFormats(string $countryCode): Collection
    {
        if (! self::supports($countryCode)) {
            throw UnsupportedCountryException::unsupported($countryCode);
        }

        return Collection::make(self::$formats[strtoupper($countryCode)]);
    }

    /** @inheritDoc */
    public function isValidFormat(string $countryCode, string $vatNumber): bool
    {
        if (! self::supports($countryCode)) {
            throw UnsupportedCountryException::unsupported($countryCode);
        }

        return $this
            ->getFormats($countryCode)
            ->whenEmpty(
                fn (Collection $collection) => true,
                function (Collection $collection) use ($vatNumber): bool {
                    return $collection->filter(function (string $format) use ($vatNumber) {
                        return true; // TODO: Fix this
                    })->isNotEmpty();
                }
            );
    }

    /** @inheritDoc */
    public function isValid(string $countryCode, string $vatNumber): bool
    {
        if (! $this->isValidFormat($countryCode, $vatNumber)) {
            return false;
        }

        try {
            $this->getInformation($countryCode, $vatNumber);

            return true;
        } catch (InvalidVatException $e) {
            return false;
        } catch (VatNotFoundException $e) {
            return false; // The driver is "complete" so any number not found is assumed to be invalid
        }
    }

    /** @inheritDoc */
    public function validate(string $countryCode, string $vatNumber): void
    {
        // TODO: Implement
    }

    /** @inheritDoc */
    public function getInformation(string $countryCode, string $vatNumber): VatInformation
    {
        $response = $this->searchByVatNumber($countryCode, $vatNumber);

        if ($response->status() === 404) {
            throw InvalidVatException::doesNotExist($vatNumber);
        }

        if (! $response->successful()) {
            throw new DriverUnavailable('CVR API is currently unavailable.');
        }

        return new VatInformation(
            company: $response->json('name'),
            vatNumber: $response->json('vat'),
            contact: null,
            address: $response->json('address'),
            postalCode: $response->json('zipcode'),
            city: $response->json('city'),
            state: null,
            region: null,
            country: $countryCode,
            sms: null,
            phone: $response->json('phone'),
            email: $response->json('email'),
        );
    }

    /** @inheritDoc */
    public function search(string $countryCode, string $search): Collection
    {
        return collect();
    }

    private function getUrl(): string
    {
        return 'https://cvrapi.dk/api';
    }

    private function getUserAgent(): string
    {
        // Required format described here: https://cvrapi.dk/documentation
        return config('vat.drivers.cvr_api.user_agent') ?? throw new InvalidArgumentException('Missing user agent.');
    }

    private function searchByVatNumber(string $countryCode, string $vatNumber): Response
    {
        return Http::withUserAgent($this->getUserAgent())
            ->get($this->getUrl(), [
                'vat' => $vatNumber,
                'country' => $countryCode,
                'version' => 6,
                'format' => 'json',
                'token' => $this->accessToken,
            ]);
    }
}
