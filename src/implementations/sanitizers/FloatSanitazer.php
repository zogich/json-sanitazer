<?php

declare(strict_types=1);

namespace src\implementations\sanitizers;

use InvalidArgumentException;
use src\implementations\sanitizers\FloatSanitazer;
use src\interfaces\sanitizers\SanitazerInterface;

/** @implements SanitazerInterface<float> */
final class FloatSanitazer implements SanitazerInterface
{
    public function sanitaze(array|string|int|float $value): float
    {
        $result = filter_var($value, FILTER_VALIDATE_FLOAT);

        if ($result === false) {
            throw new InvalidArgumentException("Cant transform '{$value}' to float");
        }

        return $result;
    }

    public function clone(): FloatSanitazer
    {
        return new FloatSanitazer();
    }
}
