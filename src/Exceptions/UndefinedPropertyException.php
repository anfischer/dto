<?php
declare(strict_types=1);

namespace Anfischer\Dto\Exceptions;

class UndefinedPropertyException extends DtoException
{
    /**
     * @param string $class
     * @param string $property
     */
    public function __construct(string $class, string $property)
    {
        parent::__construct("${class}::${property} is undefined");
    }
}
