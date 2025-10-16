<?php

namespace common;

/**
 * @template T of string|int|array
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
