<?php
declare(strict_types=1);

namespace Anfischer\Dto\Types;

interface TypeInterface
{
    public function validate($value): bool;
}
