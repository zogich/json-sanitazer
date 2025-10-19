<?php

declare(strict_types=1);

namespace src\implementations\sanitizers;

use InvalidArgumentException;
use src\interfaces\sanitizers\SanitizerInterface;

/** @implements SanitazerInterface<float> */
final class FloatSanitizer implements SanitizerInterface
{
    public function sanitaze(array|string|int|float $value): float
    {
        $result = filter_var($value, FILTER_VALIDATE_FLOAT);

        if ($result === false) {
            throw new InvalidArgumentException("Cant transform '{$value}' to float");
        }

        return $result;
    }

    public function clone(): FloatSanitizer
    {
        return new FloatSanitizer();
    }
}
