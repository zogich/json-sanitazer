<?php

require_once 'vendor/autoload.php';

use src\implementations\sanitizers\ArraySanitazer;
use src\implementations\sanitizers\FloatSanitazer;
use src\implementations\sanitizers\IntegerSanitazer;
use src\implementations\JsonParser;
use src\implementations\sanitizers\PhoneSanitazer;
use src\implementations\sanitizers\StringSanitazer;
use src\implementations\sanitizers\StructSanitazer;

$parser = new JsonParser();
$parser->setParseScheme(
    scheme: new StructSanitazer(
        [
          new ArraySanitazer(new StructSanitazer([new IntegerSanitazer()])),
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
);

var_dump($parser->parse(jsonString: '{
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
  }'));
