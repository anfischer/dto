<?php
declare(strict_types=1);

namespace Anfischer\Dto\Types;

class IntegerType implements TypeInterface
{
    public function validate($value): bool
    {
        return \is_int($value);
    }
}
