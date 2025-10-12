<?php

require_once 'vendor/autoload.php';

use common\JsonParser;
use common\SupportedTypes;

$parser = new JsonParser();
$parser->setParseScheme(
    scheme: [
      'integer_value' => SupportedTypes::INTEGER_VALUE,
  ]
);

$parser->parse(jsonString: '{"foo": "123"}');
