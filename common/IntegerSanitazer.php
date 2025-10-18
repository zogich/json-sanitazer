<?php

declare(strict_types=1);

namespace common;

use InvalidArgumentException;

/**
 * @implements SanitizerInterface<int>
 */
final class IntegerSanitazer implements SanitazerInterface
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

    public function clone(): IntegerSanitazer
    {
        return new IntegerSanitazer();
    }
}
