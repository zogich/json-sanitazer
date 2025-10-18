<?php

declare(strict_types=1);

namespace src\implementations\sanitizers;

use src\implementations\sanitizers\StringSanitazer;
use src\interfaces\sanitizers\SanitazerInterface;

/** @implements SanitazerInterface<string> */
final class StringSanitazer implements SanitazerInterface
{
    public function sanitaze(array|string|int|float $value): string
    {
        if (is_array($value)) {
            return json_encode($value);
        }

        return strval($value);
    }

    public function clone(): StringSanitazer
    {
        return new StringSanitazer();
    }
}
