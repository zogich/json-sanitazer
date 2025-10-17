<?php

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
        // $this->recursiveParseScheme($scheme, $this->parseScheme);
        $this->parseScheme = $scheme;
    }

    public function parse(string $jsonString): array|string|int|float
    {
        $preparedForSanitatingJson = json_decode($jsonString, associative: true);

        return $this->parseScheme->sanitaze($preparedForSanitatingJson);
    }

    // private function recursiveParseScheme(array $scheme, CompositeInterface $parseScheme): void
    // {
    //     foreach ($scheme as $element) {
    //         switch ($element) {
    //             case SupportedTypes::INTEGER_VALUE:
    //                 $parseScheme->addChild(new IntegerSanitazer());
    //
    //                 break;
    //             case SupportedTypes::ARRAY_VALUE:
    //                 $sanitazer = new ArraySanitazer();
    //                 $parseScheme->addChild($sanitazer);
    //
    //                 $this->recursiveParseScheme($element, $sanitazer);
    //
    //                 break;
    //         }
    //     }
    //
    // }
}
