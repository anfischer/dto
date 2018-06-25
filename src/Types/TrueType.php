<?php
declare(strict_types=1);

namespace Anfischer\Dto\Types;

class TrueType implements TypeInterface
{
    public function validate($value): bool
    {
        return \is_bool($value) && $value === true;
    }
}
