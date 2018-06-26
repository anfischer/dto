<?php
declare(strict_types=1);

namespace Anfischer\Dto\Types;

class MixedType implements TypeInterface
{
    public function isSatisfiedBy($value): bool
    {
        return true;
    }
}
