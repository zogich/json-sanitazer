<?php

require_once 'vendor/autoload.php';

use src\implementations\JsonParser;
use src\implementations\sanitizers\ArraySanitizer;
use src\implementations\sanitizers\FloatSanitizer;
use src\implementations\sanitizers\IntegerSanitizer;
use src\implementations\sanitizers\PhoneSanitizer;
use src\implementations\sanitizers\StringSanitizer;
use src\implementations\sanitizers\StructSanitizer;

$parser = new JsonParser();
$parser->setParseScheme(
    scheme: new StructSanitizer(
        [
          new ArraySanitizer(
              new StructSanitizer(
                  [
                    new IntegerSanitizer(),
                  ]
              )
          ),
          new IntegerSanitizer(),
          new StructSanitizer(
              [
                new IntegerSanitizer(),
                new IntegerSanitizer(),
                new StructSanitizer(
                    [
                      new IntegerSanitizer(),
                      new StringSanitizer(),
                      new FloatSanitizer(),
                      new PhoneSanitizer(),
                    ]
                ),
              ]
          ),
        ]
    )
);

$result = $parser->parse(jsonString: '{
  "foo": [{"testclone": 3}, {"testclone2": 4}],
  "boo": "12345",
  "goo": 
    {
      "child_goo": "1123",
      "another_goo_child": "3", 
      "yet_another_child_goo": 
          [
              "100", ["asddsa"], "3.123", "8 (950) 288-56-23"
          ]
    }
  }');

var_dump($result);
