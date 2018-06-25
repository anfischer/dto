<?php

namespace Anfischer\Dto\Tests;

use Anfischer\Dto\Dto;
use Anfischer\Dto\Exceptions\InvalidTypeException;
use Anfischer\Dto\Tests\Fixture\Dummy;
use PHPUnit\Framework\TestCase;

class TypeHintedDtoTest extends TestCase
{
    use GetTypeOfTrait;

    private $typeHintedDto;

    public function setUp()
    {
        parent::setUp();

        $this->typeHintedDto = new class() extends Dto {
            protected $string;
            protected $integer;
            protected $double;
            protected $boolean;
            protected $true;
            protected $false;
            protected $array;
            protected $resource;
            protected $null;
            protected $object;
            protected $mixed;

            public function getPropertyType($property) : string
            {
                switch ($property) {
                    case 'string':
                        return 'string';
                    case 'integer':
                        return 'integer';
                    case 'double':
                        return 'double';
                    case 'boolean':
                        return 'boolean';
                    case 'true':
                        return 'true';
                    case 'false':
                        return 'false';
                    case 'array':
                        return 'array';
                    case 'resource':
                        return 'resource';
                    case 'null':
                        return 'null';
                    case 'object':
                        return Dummy::class;
                    case 'mixed':
                        return 'mixed';
                }
            }
        };
    }

    /** @test */
    public function it_can_set_a_string_property() : void
    {
        $this->typeHintedDto->string = 'foo';
        $this->assertEquals('foo', $this->typeHintedDto->string);
    }

    /** @test */
    public function it_can_set_a_integer_property() : void
    {
        $this->typeHintedDto->integer = 1;
        $this->assertEquals(1, $this->typeHintedDto->integer);
    }

    /** @test */
    public function it_can_set_a_double_property() : void
    {
        $this->typeHintedDto->double = 1.1;
        $this->assertEquals(1.1, $this->typeHintedDto->double);
    }

    /** @test */
    public function it_can_set_a_boolean_property() : void
    {
        $this->typeHintedDto->boolean = true;
        $this->assertEquals(true, $this->typeHintedDto->boolean);
    }

    /** @test */
    public function it_can_set_a_boolean_true_property() : void
    {
        $this->typeHintedDto->true = true;
        $this->assertEquals(true, $this->typeHintedDto->true);
    }

    /** @test */
    public function it_can_set_a_boolean_false_property() : void
    {
        $this->typeHintedDto->false = false;
        $this->assertEquals(false, $this->typeHintedDto->false);
    }

    /** @test */
    public function it_can_set_an_array_property() : void
    {
        $this->typeHintedDto->array = [];
        $this->assertEquals([], $this->typeHintedDto->array);
    }

    /** @test */
    public function it_can_set_a_resource_property() : void
    {
        $resource = fopen('data://text/plain,dummy-resource', 'r');
        $this->typeHintedDto->resource = $resource;
        $this->assertEquals($resource, $this->typeHintedDto->resource);
    }

    /** @test */
    public function it_can_set_a_null_property() : void
    {
        $this->typeHintedDto->null = null;
        $this->assertEquals(null, $this->typeHintedDto->null);
    }

    /** @test */
    public function it_can_set_an_object_property() : void
    {
        $object = new Dummy;
        $this->typeHintedDto->object = $object;
        $this->assertEquals($object, $this->typeHintedDto->object);
    }

    /** @test */
    public function it_can_set_a_mixed_property()
    {
        $this->typeHintedDto->mixed = 'string';
        $this->assertEquals('string', $this->typeHintedDto->mixed);

        $this->typeHintedDto->mixed = 1;
        $this->assertEquals(1, $this->typeHintedDto->mixed);
    }

    /**
     * @test
     * @dataProvider invalidStringTypesProvider
     * @param string $property
     * @param $value
     */
    public function it_throws_an_invalid_type_exception_if_invalid_types_are_provided_for_a_string_property(string $property, $value) : void
    {
        $this->expectException(InvalidTypeException::class);
        $valueType = $this->getTypeOf($value);
        $this->expectExceptionMessage("::string must be of type 'string' (type '${valueType}' given)");

        $this->typeHintedDto->$property = $value;
    }

    /**
     * @test
     * @dataProvider invalidIntegerTypesProvider
     * @param string $property
     * @param $value
     */
    public function it_throws_an_invalid_type_exception_if_invalid_types_are_provided_for_an_integer_property(string $property, $value) : void
    {
        $this->expectException(InvalidTypeException::class);
        $valueType = $this->getTypeOf($value);
        $this->expectExceptionMessage("::integer must be of type 'integer' (type '${valueType}' given)");

        $this->typeHintedDto->$property = $value;
    }

    /**
     * @test
     * @dataProvider invalidDoubleTypesProvider
     * @param string $property
     * @param $value
     */
    public function it_throws_an_invalid_type_exception_if_invalid_types_are_provided_for_a_double_property(string $property, $value) : void
    {
        $this->expectException(InvalidTypeException::class);
        $valueType = $this->getTypeOf($value);
        $this->expectExceptionMessage("::double must be of type 'double' (type '${valueType}' given)");

        $this->typeHintedDto->$property = $value;
    }

    /**
     * @test
     * @dataProvider invalidBooleanTypesProvider
     * @param string $property
     * @param $value
     */
    public function it_throws_an_invalid_type_exception_if_invalid_types_are_provided_for_a_boolean_property(string $property, $value) : void
    {
        $this->expectException(InvalidTypeException::class);
        $valueType = $this->getTypeOf($value);
        $this->expectExceptionMessage("::boolean must be of type 'boolean' (type '${valueType}' given)");

        $this->typeHintedDto->$property = $value;
    }

    /**
     * @test
     * @dataProvider invalidTrueTypesProvider
     * @param string $property
     * @param $value
     */
    public function it_throws_an_invalid_type_exception_if_invalid_types_are_provided_for_a_true_property(string $property, $value) : void
    {
        $this->expectException(InvalidTypeException::class);
        $valueType = $this->getTypeOf($value);
        $this->expectExceptionMessage("::true must be of type 'true' (type '${valueType}' given)");

        $this->typeHintedDto->$property = $value;
    }

    /**
     * @test
     * @dataProvider invalidFalseTypesProvider
     * @param string $property
     * @param $value
     */
    public function it_throws_an_invalid_type_exception_if_invalid_types_are_provided_for_a_false_property(string $property, $value) : void
    {
        $this->expectException(InvalidTypeException::class);
        $valueType = $this->getTypeOf($value);
        $this->expectExceptionMessage("::false must be of type 'false' (type '${valueType}' given)");

        $this->typeHintedDto->$property = $value;
    }

    /**
     * @test
     * @dataProvider invalidArrayTypesProvider
     * @param string $property
     * @param $value
     */
    public function it_throws_an_invalid_type_exception_if_invalid_types_are_provided_for_an_array_property(string $property, $value) : void
    {
        $this->expectException(InvalidTypeException::class);
        $valueType = $this->getTypeOf($value);
        $this->expectExceptionMessage("::array must be of type 'array' (type '${valueType}' given)");

        $this->typeHintedDto->$property = $value;
    }

    /**
     * @test
     * @dataProvider invalidResourceTypesProvider
     * @param string $property
     * @param $value
     */
    public function it_throws_an_invalid_type_exception_if_invalid_types_are_provided_for_a_resource_property(string $property, $value) : void
    {
        $this->expectException(InvalidTypeException::class);
        $valueType = $this->getTypeOf($value);
        $this->expectExceptionMessage("::resource must be of type 'resource' (type '${valueType}' given)");

        $this->typeHintedDto->$property = $value;
    }

    /**
     * @test
     * @dataProvider invalidNullTypesProvider
     * @param string $property
     * @param $value
     */
    public function it_throws_an_invalid_type_exception_if_invalid_types_are_provided_for_a_null_property(string $property, $value) : void
    {
        $this->expectException(InvalidTypeException::class);
        $valueType = $this->getTypeOf($value);
        $this->expectExceptionMessage("::null must be of type 'null' (type '${valueType}' given)");

        $this->typeHintedDto->$property = $value;
    }

    /**
     * @test
     * @dataProvider invalidObjectTypesProvider
     * @param string $property
     * @param $value
     */
    public function it_throws_an_invalid_type_exception_if_invalid_types_are_provided_for_an_object_property(string $property, $value) : void
    {
        $this->expectException(InvalidTypeException::class);
        $valueType = $this->getTypeOf($value);
        $classPath = Dummy::class;
        $this->expectExceptionMessage("::object must be of type '${classPath}' (type '${valueType}' given)");

        $this->typeHintedDto->$property = $value;
    }

    public function invalidStringTypesProvider() : array
    {
        return [
            ['string', 1],
            ['string', 1.1],
            ['string', true],
            ['string', false],
            ['string', []],
            ['string', fopen('data://text/plain,dummy-resource', 'r')],
            ['string', null],
            ['string', new Dummy],
        ];
    }

    public function invalidIntegerTypesProvider() : array
    {
        return [
            ['integer', 'string'],
            ['integer', 1.1],
            ['integer', true],
            ['integer', false],
            ['integer', []],
            ['integer', fopen('data://text/plain,dummy-resource', 'r')],
            ['integer', null],
            ['integer', new Dummy],
        ];
    }

    public function invalidDoubleTypesProvider() : array
    {
        return [
            ['double', 'string'],
            ['double', 1],
            ['double', true],
            ['double', false],
            ['double', []],
            ['double', fopen('data://text/plain,dummy-resource', 'r')],
            ['double', null],
            ['double', new Dummy],
        ];
    }

    public function invalidBooleanTypesProvider() : array
    {
        return [
            ['boolean', 'string'],
            ['boolean', 1],
            ['boolean', 1.1],
            ['boolean', []],
            ['boolean', fopen('data://text/plain,dummy-resource', 'r')],
            ['boolean', null],
            ['boolean', new Dummy],
        ];
    }

    public function invalidTrueTypesProvider() : array
    {
        return [
            ['true', 'string'],
            ['true', 1],
            ['true', 1.1],
            ['true', false],
            ['true', []],
            ['true', fopen('data://text/plain,dummy-resource', 'r')],
            ['true', null],
            ['true', new Dummy],
        ];
    }

    public function invalidFalseTypesProvider() : array
    {
        return [
            ['false', 'string'],
            ['false', 1],
            ['false', 1.1],
            ['false', true],
            ['false', []],
            ['false', fopen('data://text/plain,dummy-resource', 'r')],
            ['false', null],
            ['false', new Dummy],
        ];
    }

    public function invalidArrayTypesProvider() : array
    {
        return [
            ['array', 'string'],
            ['array', 1],
            ['array', 1.1],
            ['array', true],
            ['array', false],
            ['array', fopen('data://text/plain,dummy-resource', 'r')],
            ['array', null],
            ['array', new Dummy],
        ];
    }

    public function invalidResourceTypesProvider() : array
    {
        return [
            ['resource', 'string'],
            ['resource', 1],
            ['resource', 1.1],
            ['resource', true],
            ['resource', false],
            ['resource', []],
            ['resource', null],
            ['resource', new Dummy],
        ];
    }

    public function invalidNullTypesProvider() : array
    {
        return [
            ['null', 'string'],
            ['null', 1],
            ['null', 1.1],
            ['null', true],
            ['null', false],
            ['null', []],
            ['null', fopen('data://text/plain,dummy-resource', 'r')],
            ['null', new Dummy],
        ];
    }

    public function invalidObjectTypesProvider() : array
    {
        return [
            ['object', 'string'],
            ['object', 1],
            ['object', 1.1],
            ['object', true],
            ['object', false],
            ['object', []],
            ['object', fopen('data://text/plain,dummy-resource', 'r')],
            ['object', null],
        ];
    }
}
