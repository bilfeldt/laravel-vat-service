<?php

namespace Bilfeldt\VatService\Exceptions;

use RuntimeException;

/**
 * This exception is thrown when a VAT number is invalid,
 * either because it has an invalid format or because it simply does not exist.
 */
class InvalidVatException extends RuntimeException
{
    public static function invalidFormat(string $vatNumber): self
    {
        return new self("VAT number {$vatNumber} has invalid format.");
    }

    public static function doesNotExist(string $vatNumber): self
    {
        return new self('VAT number {$vatNumber} does not exist.');
    }
}