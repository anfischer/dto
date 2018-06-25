<?php
declare(strict_types=1);

namespace Anfischer\Dto\Types;

class NullType implements TypeInterface
{
    public function validate($value): bool
    {
        return $value === null;
    }
}
