<?php

namespace common;

/**
 * @template T of string|int
 */
interface SanitazerInterface
{
    /**
    * @return T
    */
    public function sanitaze(string $value): string| int;

}
