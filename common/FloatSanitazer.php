<?php

declare(strict_types=1);

namespace common;

/** @implements SanitazerInterface<float> */
final class FloatSanitazer implements SanitazerInterface
{
    public function sanitaze(array|string $value): float
    {
        return floatval($value);
    }
}
