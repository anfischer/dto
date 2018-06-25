# DTO - PHP Data Transfer Object

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

A PHP implementation of the Data Transfer Object pattern (https://martinfowler.com/eaaCatalog/dataTransferObject.html).  
The Data Transfer Object allows for public properties with forced validation of their data types.

This implementation supports all of PHP's eight primitive data types:
- String
- Integer
- Double _(or by PHP-implementation floating point numbers)_
- Boolean
- Array
- Object
- Null
- Resource

As well as forced boolean values of:
- True  
_and_
- False

## Install

Via Composer

``` bash
$ composer require anfischer/dto
```

## Usage
The DTO class can be used to generate generic Data Transfer Objects which
does not enforce initializing type, but guaranties strict types for initialized
properties (e.g. a property which is first initialized as string can not be changed to integer later)
``` php
use Anfischer\Dto\Dto;

class GenericDataTransferObject extends Dto
{
    protected $someProperty;
    protected $anotherProperty;
}

$dto = new GenericDataTransferObject;
$dto->someProperty = 1;
$dto->anotherProperty = null;

// ERROR - throws InvalidTypeException since type is changed from integer to string
$dto->someProperty = 'foo';

// OK - since it was first initialized as null
$dto->anotherProperty = 'foo';
```

The DTO class also allows for generating type hinted Data Transfer Objects.  
When forcing types properties can not be initialized with other types than defined for the
properties (e.g. a property which is defined as string can not be initialized as integer)

``` php
use Anfischer\Dto\Dto;

class TypeHintedDataTransferObject extends Dto
{
    protected $stringProperty;
    protected $integerProperty;
    
    public function getPropertyType($property): string
    {
        switch ($property) {
            case 'stringProperty':
                return 'string';
            case 'integerProperty':
                return 'integer';
        }
    }
}

$dto = new TypeHintedDataTransferObject;

$dto->stringProperty = 'foo';
$dto->integerProperty = 1;

// ERROR - throws InvalidTypeException since type has to be initialized as string
$dto->stringProperty = 1;

// ERROR - throws InvalidTypeException since type has to be initialized as integer
$dto->integerProperty = 'foo';
```

Finally, the DTO class allows for generating type hinted Data Transfer Objects with mixed types.  
``` php
use Anfischer\Dto\Dto;

class TypeHintedDataTransferObject extends Dto
{
    protected $mixedProperty;
    
    public function getPropertyType($property): string
    {
        switch ($property) {
            case 'mixedProperty':
                return 'string|integer|array';
        }
    }
}

$dto = new MixedTypeHintedDataTransferObject;

$dto->mixedProperty = 'foo';
$dto->mixedProperty = 1;
$dto->mixedProperty = ['foo', 'bar', 'baz'];

// ERROR - throws InvalidTypeException since type has to be either string, integer or array
$dto->mixedProperty = 1.1;

// ERROR - throws InvalidTypeException since type has to be either string, integer or array
$dto->mixedProperty = false;
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email kontakt@season.dk instead of using the issue tracker.

## Credits

- [Andreas Fischer][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/anfischer/dto.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/anfischer/dto/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/anfischer/dto.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/anfischer/dto.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/anfischer/dto.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/anfischer/dto
[link-travis]: https://travis-ci.org/anfischer/dto
[link-scrutinizer]: https://scrutinizer-ci.com/g/anfischer/dto/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/anfischer/dto
[link-downloads]: https://packagist.org/packages/anfischer/dto
[link-author]: https://github.com/anfischer
[link-contributors]: ../../contributors
