<?php
declare(strict_types=1);

namespace Anfischer\Dto\Types;

class FalseType implements TypeInterface
{
    public function isSatisfiedBy($value): bool
    {
        return \is_bool($value) && $value === false;
    }
}
