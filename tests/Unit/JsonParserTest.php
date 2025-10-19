<?php

namespace Tests\Unit;

use Codeception\Test\Unit;
use Exception;
use src\implementations\JsonParser;
use src\implementations\sanitizers\ArraySanitizer;
use src\implementations\sanitizers\FloatSanitizer;
use src\implementations\sanitizers\IntegerSanitizer;
use src\implementations\sanitizers\PhoneSanitizer;
use src\implementations\sanitizers\StringSanitizer;
use src\implementations\sanitizers\StructSanitizer;

class JsonParserTest extends Unit
{
    private const string TEST_STRING_VARIABLE_NAME = 'test_string_variable';
    private const string TEST_STRING_VALUE = 'string_value';
    private const string TEST_INT_VARIABLE_NAME = 'test_int_variable';
    private const int TEST_INT_VALUE = 11111111;
    private const float TEST_FLOAT_VALUE = 10.101;
    private const string TEST_FLOAT_VARIABLE_NAME = 'test_float_variable';
    private const string FIRST_TEST_PHONE_VARIABLE_NAME = 'first_test_phone_variable';
    private const string FIRST_TEST_PHONE_VALUE = '8 (950) 288-56-23';
    private const string SANITAZED_FIRST_PHONE_VALUE = '79502885623';
    private const string INVALID_NUMERIC_VALUE = '123fff11';

    private JsonParser $sut;

    public function testSanitazeString(): void
    {
        $this->sut->setParseScheme(
            new StringSanitizer(),
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
            new IntegerSanitizer(),
        );

        $expectedValue = self::TEST_INT_VALUE;

        $result = $this->sut->parse(json_encode(self::TEST_INT_VALUE));

        $this->assertEquals($expectedValue, $result, 'Json содержащий целочисленное значение неправильно преобразован');
    }

    public function testIntSanitazerGetWrongValue(): void
    {
        $this->sut->setParseScheme(
            new IntegerSanitizer()
        );

        $this->expectException(Exception::class);

        $this->sut->parse(json_encode(self::INVALID_NUMERIC_VALUE));
    }

    public function testSanitazeFloat(): void
    {
        $this->sut->setParseScheme(
            scheme: new FloatSanitizer()
        );

        $expectedValue = self::TEST_FLOAT_VALUE;

        $result = $this->sut->parse(json_encode(self::TEST_FLOAT_VALUE));

        $this->assertEquals($expectedValue, $result, 'Json содержащий float неправильно преобразован');
    }

    public function testFloatSanitazerGetWrongWalue(): void
    {
        $this->sut->setParseScheme(
            scheme: new FloatSanitizer()
        );

        $this->expectException(Exception::class);

        $this->sut->parse(json_encode(self::INVALID_NUMERIC_VALUE));
    }

    public function testSanitazePhone(): void
    {
        $this->sut->setParseScheme(
            scheme: new PhoneSanitizer()
        );

        $expectedValue = self::SANITAZED_FIRST_PHONE_VALUE;

        $result = $this->sut->parse(json_encode(self::FIRST_TEST_PHONE_VALUE));

        $this->assertEquals($expectedValue, $result, 'Json содержащий номер телефона неправильно преобразованы');
    }

    public function testPhoneSanitazerGetWrongValue(): void
    {
        $this->sut->setParseScheme(
            scheme: new PhoneSanitizer()
        );

        $this->expectException(Exception::class);

        $this->sut->parse(json_encode(self::INVALID_NUMERIC_VALUE));
    }

    public function testSanitazeArrayOfInteger(): void
    {
        $this->sut->setParseScheme(
            scheme: new ArraySanitizer(new IntegerSanitizer())
        );

        $expectedValue = [
          1, 2, 3, 4, 5,
        ];

        $result = $this->sut->parse(json_encode($expectedValue));

        $this->assertEquals($expectedValue, $result);
    }

    public function testArraySanitazerGetWrongValue(): void
    {
        $this->sut->setParseScheme(new ArraySanitizer(new IntegerSanitizer()));

        $this->expectException(Exception::class);

        $this->sut->parse(json_encode(self::TEST_FLOAT_VALUE));
    }

    public function testArraySanitazerGetWrongValueInsideArray(): void
    {
        $this->sut->setParseScheme(new ArraySanitizer(new PhoneSanitizer()));

        $valueWithWrongPhone = [self::FIRST_TEST_PHONE_VALUE, '123321'];

        $this->expectException(Exception::class);

        $this->sut->parse(json_encode($valueWithWrongPhone));
    }

    public function testSanitazeStruct(): void
    {
        $this->sut->setParseScheme(
            scheme: new StructSanitizer(
                [
                  new IntegerSanitizer(),
                  new StringSanitizer(),
                  new FloatSanitizer(),
                  new PhoneSanitizer(),
                ]
            )
        );

        $valueForSanitazing = [
          self::TEST_INT_VARIABLE_NAME => self::TEST_INT_VALUE,
          self::TEST_STRING_VARIABLE_NAME => self::TEST_STRING_VALUE,
          self::TEST_FLOAT_VARIABLE_NAME => self::TEST_FLOAT_VALUE,
          self::FIRST_TEST_PHONE_VARIABLE_NAME => self::FIRST_TEST_PHONE_VALUE,
        ];

        $expectedValue = $valueForSanitazing;
        $expectedValue[self::FIRST_TEST_PHONE_VARIABLE_NAME] = self::SANITAZED_FIRST_PHONE_VALUE;

        $result = $this->sut->parse(json_encode($valueForSanitazing));

        $this->assertEquals($expectedValue, $result, 'Json содержащий структуру неправильно преобразован');
    }

    public function testStructSanitazerGetWrongValue(): void
    {
        $this->sut->setParseScheme(new StructSanitizer([new IntegerSanitizer()]));

        $this->expectException(Exception::class);

        $this->sut->parse(json_encode(self::TEST_FLOAT_VALUE));
    }

    public function testStructureSanitazerGetWrongValueInsideOfStructure(): void
    {
        $this->sut->setParseScheme(
            new StructSanitizer(
                [
                  new IntegerSanitizer(),
                  new FloatSanitizer(),
                ]
            )
        );

        $structWithWrongFLoat = [
          self::TEST_INT_VARIABLE_NAME => self::TEST_INT_VALUE,
          self::TEST_FLOAT_VARIABLE_NAME => 'wrong_float',
        ];

        $this->expectException(Exception::class);

        $this->sut->parse(json_encode($structWithWrongFLoat));
    }

    public function testSanitazeArrayOfStructures(): void
    {
        $this->sut->setParseScheme(new ArraySanitizer(
            new StructSanitizer(
                [
                  new IntegerSanitizer(),
                  new StringSanitizer(),
                  new FloatSanitizer(),
                  new PhoneSanitizer(),
                ]
            )
        ));

        $valueForSanitazing = [
          0 => [
              self::TEST_INT_VARIABLE_NAME => self::TEST_INT_VALUE,
              self::TEST_STRING_VARIABLE_NAME => self::TEST_STRING_VALUE,
              self::TEST_FLOAT_VARIABLE_NAME => self::TEST_FLOAT_VALUE,
              self::FIRST_TEST_PHONE_VARIABLE_NAME => self::FIRST_TEST_PHONE_VALUE,
          ],
          1 => [
              self::TEST_INT_VARIABLE_NAME => self::TEST_INT_VALUE,
              self::TEST_STRING_VARIABLE_NAME => self::TEST_STRING_VALUE,
              self::TEST_FLOAT_VARIABLE_NAME => self::TEST_FLOAT_VALUE,
              self::FIRST_TEST_PHONE_VARIABLE_NAME => self::FIRST_TEST_PHONE_VALUE,
          ],
        ];

        $expectedValue = $valueForSanitazing;
        $expectedValue[0][self::FIRST_TEST_PHONE_VARIABLE_NAME] = self::SANITAZED_FIRST_PHONE_VALUE;
        $expectedValue[1][self::FIRST_TEST_PHONE_VARIABLE_NAME] = self::SANITAZED_FIRST_PHONE_VALUE;

        $result = $this->sut->parse(json_encode($valueForSanitazing));

        $this->assertEquals($expectedValue, $result);
    }

    public function testSanitazeStructOfArrays(): void
    {
        $this->sut->setParseScheme(
            new StructSanitizer(
                [
                  new ArraySanitizer(new IntegerSanitizer()),
                  new ArraySanitizer(new StringSanitizer()),
                ]
            )
        );

        $expectedValue = [
          'dummy_key' => [
            1, 2, 3, 4, 5,
          ],
          'yet_one_dummy_key' => [
            'aaa', 'bbb', 'ccc',
          ],
        ];

        $result = $this->sut->parse(json_encode($expectedValue));

        $this->assertEquals($expectedValue, $result);
    }

    protected function _before(): void
    {
        $this->sut = new JsonParser();
    }
}
