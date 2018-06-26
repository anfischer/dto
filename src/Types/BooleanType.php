<?php
declare(strict_types=1);

namespace Anfischer\Dto\Types;

class BooleanType implements TypeInterface
{
    public function isSatisfiedBy($value): bool
    {
        return \is_bool($value);
    }
}
