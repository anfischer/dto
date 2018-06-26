<?php
declare(strict_types=1);

namespace Anfischer\Dto\Types;

class DoubleType implements TypeInterface
{
    public function validate($value): bool
    {
        return \is_float($value);
    }
}
