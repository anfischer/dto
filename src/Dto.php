<?php
declare(strict_types=1);

namespace Anfischer\Dto;

use Anfischer\Dto\Exceptions\InvalidTypeException;
use Anfischer\Dto\Exceptions\UndefinedPropertyException;

abstract class Dto
{
    protected const TYPE_SEPARATOR = '|';

    /**
     * Magic method for setting the properties of the DTO
     *
     * @param string $property
     * @param mixed $value
     * @throws InvalidTypeException
     * @throws UndefinedPropertyException
     */
    public function __set(string $property, $value): void
    {
        $type = $this->getPropertyType($property);

        if (self::validateCompoundTypes($type, $value)) {
            $this->$property = $value;
        } else {
            throw new InvalidTypeException(\get_class($this), $property, $type, self::getTypeOf($value));
        }
    }

    /**
     * Magic method for getting the properties of the DTO
     *
     * @param string $property
     * @return mixed
     * @throws UndefinedPropertyException
     */
    public function __get(string $property)
    {
        if ($this->__isset($property)) {
            return $this->$property;
        }

        throw new UndefinedPropertyException(\get_class($this), $property);
    }

    /**
     * Magic method for checking if a property is set
     *
     * @param $property
     * @return bool
     */
    public function __isset(string $property): bool
    {
        return property_exists($this, $property);
    }

    /**
     * Gets the property's type.
     * The method can be overridden per DTO basis to refine/restrict property types
     *
     * @param  string $property
     * @return string
     */
    public function getPropertyType($property): string
    {
        $value = $this->$property;

        if ($value === null) {
            // If value is not set, allow any value
            return 'mixed';
        }

        return self::getTypeOf($this->$property);
    }

    /**
     * Validates the properties types
     * Types can be separated by TYPE_SEPARATOR (default is pipe - e.g. string|null, integer|double)
     *
     * @param  string $compoundType
     * @param  mixed $value
     * @return bool
     */
    private static function validateCompoundTypes(string $compoundType, $value): bool
    {
        $types = \explode(static::TYPE_SEPARATOR, $compoundType);

        foreach ($types as $type) {
            if (self::validateType($type, $value)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Validates a value against primitive types
     *
     * If no primitive implementation exists (an object is given) the function
     * checks if the object is of the property's class or has the property's class as one of its parents
     *
     * @param string $type
     * @param mixed $value
     * @return bool
     */
    private static function validateType(string $type, $value): bool
    {
        $typeClass = self::getTypeClassFor($type);
        if (class_exists($typeClass)) {
            return (new $typeClass())->isSatisfiedBy($value);
        }

        if (\is_a($value, $type)) {
            return true;
        }

        return false;
    }

    /**
     * @param string $type
     * @return string
     */
    private static function getTypeClassFor(string $type): string
    {
        return __NAMESPACE__ . '\\Types\\' . ucfirst($type) . 'Type';
    }

    /**
     * @param mixed $value
     * @return string
     */
    private static function getTypeOf($value): string
    {
        if (\is_object($value)) {
            return \get_class($value);
        }

        return \strtolower(\gettype($value));
    }
}
