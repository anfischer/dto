<?php

namespace Anfischer\Dto\Tests;

use Anfischer\Dto\Dto;
use Anfischer\Dto\Exceptions\InvalidTypeException;
use Anfischer\Dto\Tests\Fixture\Dummy;
use PHPUnit\Framework\TestCase;

class GenericDtoTest extends TestCase
{
    use GetTypeOfTrait;

    private $genericDto;

    public function setUp()
    {
        parent::setUp();

        $this->genericDto = new class() extends Dto {
            protected $genericPropertyOne;
            protected $genericPropertyTwo;
            protected $genericPropertyThree;
        };
    }

    /** @test */
    public function it_can_set_a_generic_property()
    {
        $this->genericDto->genericPropertyOne = 'foo';
        $this->assertEquals('foo', $this->genericDto->genericPropertyOne);

        $this->genericDto->genericPropertyTwo = 'bar';
        $this->assertEquals('bar', $this->genericDto->genericPropertyTwo);

        $this->genericDto->genericPropertyThree = 'baz';
        $this->assertEquals('baz', $this->genericDto->genericPropertyThree);
    }

    /**
     * @test
     * @dataProvider invalidStringTypesProvider
     * @param $value
     */
    public function the_property_can_not_be_overridden_with_a_value_of_a_different_type_than_the_initial_set_type($value): void
    {
        $this->genericDto->genericPropertyOne = 'foo';
        $this->assertEquals('foo', $this->genericDto->genericPropertyOne);

        $this->expectException(InvalidTypeException::class);
        $valueType = $this->getTypeOf($value);
        $this->expectExceptionMessage("::genericPropertyOne must be of type 'string' (type '${valueType}' given)");
        $this->genericDto->genericPropertyOne = $value;
    }

    public function invalidStringTypesProvider() : array
    {
        return [
            [1],
            [1.1],
            [true],
            [false],
            [[]],
            [fopen('data://text/plain,dummy-resource', 'r')],
            [null],
            [new Dummy],
        ];
    }
}
