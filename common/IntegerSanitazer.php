<?php

namespace common;

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
        return intval(
            $value
        );
    }
}
