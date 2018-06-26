<?php

namespace Anfischer\Dto\Tests;

use Anfischer\Dto\Dto;
use Anfischer\Dto\Exceptions\InvalidTypeException;
use Anfischer\Dto\Tests\Fixture\Dummy;
use PHPUnit\Framework\TestCase;

class MixedTypeHintedDtoTest extends TestCase
{
    use GetTypeOfTrait;

    private $typeHintedDto;

    public function setUp(): void
    {
        parent::setUp();

        $this->typeHintedDto = new class() extends Dto {
            protected $mixed;

            public function getPropertyType($property): string
            {
                switch ($property) {
                    case 'mixed':
                        return 'string|integer|null';
                }
            }
        };
    }

    /** @test */
    public function it_can_set_a_mixed_types_property(): void
    {
        $this->typeHintedDto->mixed = 'foo';
        $this->assertEquals('foo', $this->typeHintedDto->mixed);

        $this->typeHintedDto->mixed = 1;
        $this->assertEquals(1, $this->typeHintedDto->mixed);

        $this->typeHintedDto->mixed = null;
        $this->assertNull($this->typeHintedDto->mixed);
    }

    /** @test */
    public function but_only_if_the_type_is_allowed(): void
    {
        $this->expectException(InvalidTypeException::class);
        $this->expectExceptionMessage("::mixed must be of type 'string|integer|null' (type 'double' given)");

        $this->typeHintedDto->mixed = 1.1;
    }
}
