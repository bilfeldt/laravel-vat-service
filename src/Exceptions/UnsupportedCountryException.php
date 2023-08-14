<?php

namespace Bilfeldt\VatService\Exceptions;

use LogicException;

class UnsupportedCountryException extends LogicException implements VatExceptionInterface
{
    public static function unsupported(string $countryCode): self
    {
        return new self("Country code {$countryCode} is not supported.");
    }
}