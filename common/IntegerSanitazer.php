<?php

namespace common;

/**
 * @implements SanitizerInterface<int>
 */
final class IntegerSanitazer implements SanitazerInterface
{
    /**
    * @inheritDoc
    */
    public function sanitaze(string $value): int
    {
        return intval(
            $value
        );
    }

}
