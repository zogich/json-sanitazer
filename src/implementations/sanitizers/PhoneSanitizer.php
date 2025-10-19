<?php

declare(strict_types=1);

namespace src\implementations\sanitizers;

use Psr\Log\InvalidArgumentException;
use src\interfaces\sanitizers\SanitizerInterface;

/** @implements SanitazerInterface<string> */
final class PhoneSanitizer implements SanitizerInterface
{
    public function sanitaze(string|array|int|float $value): string
    {
        if (!$this->isValidFormat($value)) {
            throw new InvalidArgumentException(sprintf('%s - Wrong phone number format', $value));
        }
        $phoneWithOnlyNumbers = preg_replace('/\D/', '', $value);

        if (empty($phoneWithOnlyNumbers)) {
            return '';
        }

        return '7' . substr($phoneWithOnlyNumbers, 1);
    }

    public function clone(): PhoneSanitizer
    {
        return new PhoneSanitizer();
    }

    private function isValidFormat(string $value): bool
    {
        $pattern = '/^8\s\(\d{3}\)\s\d{3}-\d{2}-\d{2}$/';

        return preg_match($pattern, $value) === 1;
    }
}
