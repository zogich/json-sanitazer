<?php

declare(strict_types=1);

namespace common;

final class JsonParser
{
    private SanitazerInterface $parseScheme;

    public function __construct()
    {
    }

    /**
     * @param array $scheme
     */
    public function setParseScheme(SanitazerInterface $scheme): void
    {
        $this->parseScheme = $scheme;
    }

    public function parse(string $jsonString): array|string|int|float
    {
        $preparedForSanitatingJson = json_decode($jsonString, associative: true);

        return $this->parseScheme->sanitaze($preparedForSanitatingJson);
    }
}
