<?php

namespace Bilfeldt\VatService\Exceptions;

use RuntimeException;

/**
 * This exception is thrown when a driver is unable to find a VAT number,
 * but it cannot be ruled out that the VAT number exists, but is just
 * not found by the driver.
 *
 * In other words this means the driver is in doubt.
 */
class VatNotFoundException extends RuntimeException implements VatExceptionInterface
{
    public static function notFound(string $vatNumber): self
    {
        return new self("VAT number {$vatNumber} not found.");
    }
}