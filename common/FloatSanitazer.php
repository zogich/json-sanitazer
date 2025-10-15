<?php

declare(strict_types=1);

namespace common;

use InvalidArgumentException;

/** @implements SanitazerInterface<float> */
final class FloatSanitazer implements SanitazerInterface
{
    public function sanitaze(array|string|int $value): float
    {
        $result = filter_var($value, FILTER_VALIDATE_FLOAT);

        if ($result === false) {
            throw new InvalidArgumentException("Невозможно преобразовать '{$value}' в целое число");
        }

        return floatval($value);
    }
}
