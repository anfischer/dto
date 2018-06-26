<?php

namespace Anfischer\Dto\Tests;

use Anfischer\Dto\Dto;
use Anfischer\Dto\Exceptions\UndefinedPropertyException;
use PHPUnit\Framework\TestCase;

class DtoTest extends TestCase
{
    private $dto;

    public function setUp()
    {
        parent::setUp();

        $this->dto = new class() extends Dto {
            protected $definedProperty;
        };
    }

    /** @test */
    public function it_can_check_if_a_property_isset(): void
    {
        $this->assertFalse(isset($this->dto->someUndefinedProperty));
        $this->assertTrue(isset($this->dto->definedProperty));
    }

    /** @test */
    public function it_can_not_set_an_undefined_property(): void
    {
        $this->expectException(UndefinedPropertyException::class);
        $this->dto->foo = 'bar';
    }

    /** @test */
    public function it_can_not_get_an_undefined_property(): void
    {
        $this->expectException(UndefinedPropertyException::class);
        $this->dto->foo;
    }

    /** @test */
    public function the_default_type_separator_can_be_overridden()
    {
        $this->dto = new class() extends Dto {

            protected const TYPE_SEPARATOR = ',';
            protected $someProperty;

            public function getPropertyType($property) : string
            {
                switch ($property) {
                    case 'someProperty':
                        return 'string,integer';
                }
            }
        };

        $this->dto->someProperty = 'string';
        $this->assertEquals('string', $this->dto->someProperty);

        $this->dto->someProperty = 1;
        $this->assertEquals(1, $this->dto->someProperty);
    }
}
