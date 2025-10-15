<?php

require_once 'vendor/autoload.php';

use common\FloatSanitazer;
use common\IntegerSanitazer;
use common\JsonParser;
use common\PhoneSanitazer;
use common\StringSanitazer;
use common\StructSanitazer;

$parser = new JsonParser();
$parser->setParseScheme(
    scheme: new StructSanitazer(
        [
          new IntegerSanitazer(),
          new IntegerSanitazer(),
          new StructSanitazer(
              [
                new IntegerSanitazer(),
                new IntegerSanitazer(),
                new StructSanitazer(
                    [
                      new IntegerSanitazer(),
                      new StringSanitazer(),
                      new FloatSanitazer(),
                      new PhoneSanitazer(),
                    ]
                ),
              ]
          ),
        ]
    )
    // 'integer_value' => SupportedTypes::INTEGER_VALUE,
    // 'another_int_value' => SupportedTypes::INTEGER_VALUE,
    // 'yet_another_int_value' => SupportedTypes::INTEGER_VALUE,
    // 'array_value' => SupportedTypes::ARRAY_VALUE,
);

var_dump($parser->parse(jsonString: '{"foo": "123", "boo": "12sd345", "goo": {"child_goo": "1123", "another_goo_child": "3", "yet_another_child_goo": ["100", ["asddsa"], "3.1sda23", "8 (950) 288-56-23"]}}'));
