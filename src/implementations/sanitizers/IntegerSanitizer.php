<?php

declare(strict_types=1);

namespace src\implementations\sanitizers;

use InvalidArgumentException;
use src\interfaces\sanitizers\SanitizerInterface;

/**
 * @implements SanitizerInterface<int>
 */
final class IntegerSanitizer implements SanitizerInterface
{
    /**
     * {@inheritDoc}
     */
    public function sanitaze(array|string|int|float $value): int
    {
        if (!is_scalar($value)) {
            throw new InvalidArgumentException('Must be scalar');
        }

        $result = filter_var($value, FILTER_VALIDATE_INT);

        if ($result === false) {
            throw new InvalidArgumentException("Cant transform '{$value} to int");
        }

        return $result;
    }

    public function clone(): IntegerSanitizer
    {
        return new IntegerSanitizer();
    }
}
