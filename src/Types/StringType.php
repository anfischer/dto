<?php
declare(strict_types=1);

namespace Anfischer\Dto\Types;

class StringType implements TypeInterface
{
    public function isSatisfiedBy($value): bool
    {
        return \is_string($value);
    }
}
