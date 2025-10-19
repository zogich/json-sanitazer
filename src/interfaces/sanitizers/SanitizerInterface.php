<?php

declare(strict_types=1);

namespace src\interfaces\sanitizers;

/**
 * @template T of string|int|array|float
 */
interface SanitizerInterface
{
    /**
     * @param T $value
     *
     * @return T
     */
    public function sanitaze(string|array|int|float $value): string|int|array|float;

    public function clone(): SanitizerInterface;
}
