<?php

declare(strict_types=1);

namespace src\implementations;

use src\interfaces\sanitizers\SanitizerInterface;

final class JsonParser
{
    private SanitizerInterface $parseScheme;

    public function __construct()
    {
    }

    /**
     * @param array $scheme
     */
    public function setParseScheme(SanitizerInterface $scheme): void
    {
        $this->parseScheme = $scheme;
    }

    public function parse(string $jsonString): array|string|int|float
    {
        $preparedForSanitatingJson = json_decode($jsonString, associative: true);

        return $this->parseScheme->sanitaze($preparedForSanitatingJson);
    }
}
