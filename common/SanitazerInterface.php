<?php

namespace common;

/**
 * @template T of string|int|array
 */
interface SanitazerInterface
{
    /**
      * @param T $value
      * @return T
      */
    public function sanitaze(string|array $value): string|int|array|float;
}
