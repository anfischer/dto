<?php

namespace Anfischer\Dto\Tests;

trait GetTypeOfTrait
{
    /**
     * @param $value
     * @return string
     */
    private function getTypeOf($value): string
    {
        if (\is_object($value)) {
            return \get_class($value);
        } else {
            return \strtolower(\gettype($value));
        }
    }
}
