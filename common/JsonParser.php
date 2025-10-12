<?php

namespace common;

final class JsonParser
{
    /** @var SanitazerInterface[] */
    private array $parseScheme = [];

    /**
    * @param array $scheme
    */
    public function setParseScheme(array $scheme): void
    {
        foreach ($scheme as $element) {
            // как бы тут написать, чтобы можно было разные санитайзеры вставлять(рекурсия, фабрика, по ссылке массивы в рекурсию.)
        }
    }

    public function parse(string $jsonString): array
    {
        return [];
    }
}
