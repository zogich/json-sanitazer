<?php

declare(strict_types=1);

namespace common;

/**
 * @template T of string|int|array|float
 */
interface SanitazerInterface
{
    /**
     * @param T $value
     *
     * @return T
     */
    public function sanitaze(string|array|int|float $value): string|int|array|float;

    public function clone(): SanitazerInterface;
}
