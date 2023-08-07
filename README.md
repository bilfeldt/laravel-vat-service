# Fetch company VAT details in Laravel

![bilfeldt/laravel-vat-service](art/banner.png)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/bilfeldt/laravel-vat-service.svg?style=flat-square)](https://packagist.org/packages/bilfeldt/laravel-vat-service)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/bilfeldt/laravel-vat-service/run-tests?label=tests)](https://github.com/bilfeldt/laravel-vat-service/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/bilfeldt/laravel-vat-service.svg?style=flat-square)](https://packagist.org/packages/bilfeldt/laravel-vat-service)

Log Laravel requests and responses for statistical purposes and optionally aggregate by hours/days/months for minimal db requirements.

| Version | Laravel     | PHP                     |
|---------|-------------|-------------------------|
| 1.*     | 10.*        | 8.1.* \| 8.2.*          |

## Description



This package lets you:

- Check if a VAT number has a correct format
- Check if a VAT number is valid
- Lookup VAT details for a given VAT number
- Implement a VAT number validation rule
- Search for VAT details

## Installation

You can install the package via composer:

```bash
composer require bilfeldt/laravel-vat-service
```

## Usage

```php
$driver = $manager->getDefaultDriver();

// In Denmark the format is 8-digits
$driver->getFormats('DK'); // ['########']

$driver->isValidFormat('DK', '12345678'); // bool

// This will do an API lookup.
// Will throw a VatServiceUnavilable if the service is down
$driver->isValid('DK', '12345678'); // bool

// Will throw a validation exception
$driver->validate('DK', 'INVALID');

// Get a DTO with info about the company
$driver->getInformation('DK', '12345678'); // VatInformation

// Find relevant companies based on company name or vat number
$driver->search('DK', 'Carlsberg'); // Collection<VatInformation>


```

### Drivers

### Facade

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Anders Bilfeldt](https://github.com/bilfeldt)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
