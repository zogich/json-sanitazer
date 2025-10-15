<?php

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
    public function sanitaze(array|string|int $value): int
    {
        if (!is_scalar($value)) {
            throw new InvalidArgumentException('Значение должно быть скалярным типом');
        }

        $result = filter_var($value, FILTER_VALIDATE_INT);

        if ($result === false) {
            throw new InvalidArgumentException("Невозможно преобразовать '{$value}' в целое число");
        }

        return $result;
    }
}
