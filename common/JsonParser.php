<?php

namespace common;

final class JsonParser
{
    private ArraySanitazer $parseScheme;

    public function __construct()
    {
    }

    /**
     * @param array $scheme
     */
    public function setParseScheme(ArraySanitazer $scheme): void
    {
        // $this->recursiveParseScheme($scheme, $this->parseScheme);
        $this->parseScheme = $scheme;
    }

    public function parse(string $jsonString): array
    {
        $preparedForSanitatingJson = json_decode($jsonString, associative: true);
        var_dump($preparedForSanitatingJson);

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
