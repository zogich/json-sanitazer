<?php

declare(strict_types=1);

namespace src\implementations\sanitizers;

use src\interfaces\sanitizers\SanitizerInterface;

/** @implements SanitazerInterface<string> */
final class StringSanitizer implements SanitizerInterface
{
    public function sanitaze(array|string|int|float $value): string
    {
        if (is_array($value)) {
            return json_encode($value);
        }

        return strval($value);
    }

    public function clone(): StringSanitizer
    {
        return new StringSanitizer();
    }
}
