<?php

namespace Tests\Unit;

require_once 'vendor/autoload.php';

use Codeception\Test\Unit;
use common\IntegerSanitazer;
use common\JsonParser;
use common\StringSanitazer;
use common\StructSanitazer;

class JsonParserTest extends Unit
{
    private const string TEST_STRING_VARIABLE_NAME = 'test_string_variable';
    private const string TEST_STRING_VALUE = 'string_value';
    private const string TEST_INT_VARIABLE_NAME = 'test_int_variable';
    private const int TEST_INT_VALUE = 11111111;

    private JsonParser $sut;

    public function testSanitazeString(): void
    {
        $this->sut->setParseScheme(
            new StructSanitazer(
                [
                    new StringSanitazer(),
                ]
            )
        );

        $expectedValue = [
              self::TEST_STRING_VARIABLE_NAME => self::TEST_STRING_VALUE,
        ];

        $result = $this->sut->parse(
            json_encode(
                [self::TEST_STRING_VARIABLE_NAME => self::TEST_STRING_VALUE]
            )
        );

        codecept_debug(json_encode(['ahahaha' => 123]));

        $this->assertEquals($expectedValue, $result, 'Json содержащий строковое значение неправильно преобразован');
    }

    public function testSanitazeInt(): void
    {
        $this->sut->setParseScheme(
            new StructSanitazer(
                [
                    new IntegerSanitazer(),
                ]
            )
        );

        $expectedValue = [
          self::TEST_INT_VARIABLE_NAME => self::TEST_INT_VALUE,
        ];

        $result = $this->sut->parse(json_encode([
          self::TEST_INT_VARIABLE_NAME => self::TEST_INT_VALUE,
        ]));

        $this->assertEquals($expectedValue, $result, 'Json содержащий целочисленное значение неправильно преобразован');
    }

    protected function _before(): void
    {
        $this->sut = new JsonParser();
    }
}
