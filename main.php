<?php

require_once 'vendor/autoload.php';

use common\ArraySanitazer;
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
