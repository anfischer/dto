<?php
declare(strict_types=1);

namespace Anfischer\Dto\Exceptions;

class InvalidTypeException extends DtoException
{
    /**
     * @param string $class
     * @param string $property
     * @param string $expected
     * @param string $given
     */
    public function __construct(string $class, string $property, string $expected, string $given)
    {
        parent::__construct("${class}::${property} must be of type '${expected}' (type '${given}' given)");
    }
}
