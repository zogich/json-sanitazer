<?php

declare(strict_types=1);

namespace common;

use Psr\Log\InvalidArgumentException;

/** @implements SanitazerInterface<string> */
final class PhoneSanitazer implements SanitazerInterface
{
    public function sanitaze(string|array|int|float $value): string
    {
        if (!$this->isValidFormat($value)) {
            throw new InvalidArgumentException('Номер телефона указан в некорректном формате');
        }
        $phoneWithOnlyNumbers = preg_replace('/\D/', '', $value);

        if (empty($phoneWithOnlyNumbers)) {
            return '';
        }

        return '7' . substr($phoneWithOnlyNumbers, 1);
    }

    public function clone(): PhoneSanitazer
    {
        return new PhoneSanitazer();
    }

    private function isValidFormat(string $value): bool
    {
        $pattern = '/^8\s\(\d{3}\)\s\d{3}-\d{2}-\d{2}$/';

        return preg_match($pattern, $value) === 1;
    }
}
