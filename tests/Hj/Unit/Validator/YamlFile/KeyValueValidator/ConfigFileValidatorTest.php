<?php

namespace Hj\Unit\Validator\YamlFile\KeyValueValidator;

use Hj\Exception\YamlKeyNotDefined;
use Hj\Validator\YamlFile\KeyValueValidator\ConfigFileValidator;
use PHPUnit\Framework\TestCase;

/**
 * Class ConfigFileValidatorTest
 * @package Hj\Unit\Validator\YamlFile\KeyValueValidator
 */
class ConfigFileValidatorTest extends TestCase
{
    /**
     * @var ConfigFileValidator
     */
    private $validator;

    /**
     * @var string
     */
    private $yamlConfigFileName = 'fakeConfigFileForTest';

    protected function setUp()
    {
        $this->validator = new ConfigFileValidator();
    }

    public function dataProviderTestIsValidThrowExceptionWhenKeyIsNotValid()
    {
        return [
//            filePath
            [
                "Wrong yaml file configuration in : 'fakeConfigFileForTest'. The key 'filePath' is not defined. Please check your yaml file and define it.",
                YamlKeyNotDefined::class,
                [],
            ],
//            keyHeader
            [
                "Wrong yaml file configuration in : 'fakeConfigFileForTest'. The key 'keyHeader' is not defined. Please check your yaml file and define it.",
                YamlKeyNotDefined::class,
                [
                    'filePath' => [],
                ],
            ],
//            migrationMapping
            [
                "Wrong yaml file configuration in : 'fakeConfigFileForTest'. The key 'migrationMapping' is not defined. Please check your yaml file and define it.",
                YamlKeyNotDefined::class,
                [
                    'filePath' => [],
                    'keyHeader' => [],
                ],
            ],
//            mappingRelation
            [
                "Wrong yaml file configuration in : 'fakeConfigFileForTest'. The key 'mappingRelation' is not defined. Please check your yaml file and define it.",
                YamlKeyNotDefined::class,
                [
                    'filePath' => [],
                    'keyHeader' => [],
                    'migrationMapping' => [],
                ],
            ],
        ];
    }

    /**
     * @param $expectedExceptionMessage
     * @param $expectedException
     * @param $value
     * @dataProvider dataProviderTestIsValidThrowExceptionWhenKeyIsNotValid
     */
    public function testIsValidThrowExceptionWhenKeyIsNotValid($expectedExceptionMessage, $expectedException, $value)
    {
        $this->expectException($expectedException);
        $this->expectExceptionMessage($expectedExceptionMessage);

        $this->validator->valid(
            $value,
            $this->yamlConfigFileName
        );
    }
}