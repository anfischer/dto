<?php
declare(strict_types=1);

namespace Anfischer\Dto\Types;

class NullType implements TypeInterface
{
    public function isSatisfiedBy($value): bool
    {
        return $value === null;
    }
}
