<?php

namespace Tests\Unit;

require_once 'vendor/autoload.php';

use Codeception\Test\Unit;
use common\ArraySanitazer;
use common\FloatSanitazer;
use common\IntegerSanitazer;
use common\JsonParser;
use common\PhoneSanitazer;
use common\StringSanitazer;
use Exception;

class JsonParserTest extends Unit
{
    private const string TEST_STRING_VARIABLE_NAME = 'test_string_variable';
    private const string TEST_STRING_VALUE = 'string_value';
    private const string TEST_INT_VARIABLE_NAME = 'test_int_variable';
    private const int TEST_INT_VALUE = 11111111;
    private const float TEST_FLOAT_VALUE = 10.101;
    private const string FIRST_TEST_PHONE_VALUE = '8 (950) 288-56-23';
    private const string SANITAZED_FIRST_PHONE_VALUE = '79502885623';
    private const string INVALID_NUMERIC_VALUE = '123fff11';

    private JsonParser $sut;

    public function testSanitazeString(): void
    {
        $this->sut->setParseScheme(
            new StringSanitazer(),
        );

        $expectedValue = self::TEST_STRING_VALUE;

        $result = $this->sut->parse(
            json_encode(
                self::TEST_STRING_VALUE
            )
        );

        $this->assertEquals($expectedValue, $result, 'Json содержащий строковое значение неправильно преобразован');
    }

    public function testSanitazeInt(): void
    {
        $this->sut->setParseScheme(
            new IntegerSanitazer(),
        );

        $expectedValue = self::TEST_INT_VALUE;

        $result = $this->sut->parse(json_encode(self::TEST_INT_VALUE));

        $this->assertEquals($expectedValue, $result, 'Json содержащий целочисленное значение неправильно преобразован');
    }

    public function testIntSanitazerGetWrongValue(): void
    {
        $this->sut->setParseScheme(
            new IntegerSanitazer()
        );

        $this->expectException(Exception::class);

        $this->sut->parse(json_encode(self::INVALID_NUMERIC_VALUE));
    }

    public function testSanitazeFloat(): void
    {
        $this->sut->setParseScheme(
            scheme: new FloatSanitazer()
        );

        $expectedValue = self::TEST_FLOAT_VALUE;

        $result = $this->sut->parse(json_encode(self::TEST_FLOAT_VALUE));

        $this->assertEquals($expectedValue, $result, 'Json содержащий float неправильно преобразован');
    }

    public function testFloatSanitazerGetWrongWalue(): void
    {
        $this->sut->setParseScheme(
            scheme: new FloatSanitazer()
        );

        $this->expectException(Exception::class);

        $this->sut->parse(json_encode(self::INVALID_NUMERIC_VALUE));
    }

    public function testSanitazePhone(): void
    {
        $this->sut->setParseScheme(
            scheme: new PhoneSanitazer()
        );

        $expectedValue = '79502885623';

        $result = $this->sut->parse(json_encode(self::FIRST_TEST_PHONE_VALUE));

        $this->assertEquals($expectedValue, $result);
    }

    public function testPhoneSanitazerGetWrongValue(): void
    {
        $this->sut->setParseScheme(
            scheme: new PhoneSanitazer()
        );

        $this->expectException(Exception::class);

        $this->sut->parse(json_encode(self::INVALID_NUMERIC_VALUE));
    }

    public function testSanitazeArrayOfInteger(): void
    {
        $this->sut->setParseScheme(
            scheme: new ArraySanitazer()
        );
    }

    protected function _before(): void
    {
        $this->sut = new JsonParser();
    }
}
