# nia - Validation

Validation component provides classes and interfaces to validate values.

## Installation

Require this package with Composer.

```bash
	composer require nia/validation
```

## Tests
To run the unit test use the following command:

    $ cd /path/to/nia/component/
    $ phpunit --bootstrap=vendor/autoload.php tests/

## Validators
The component provides several validators but you are able to write your own validator by implementing the `Nia\Validation\ValidatorInterface` interface for a more specific use case.

| Validator | Description |
| --- | --- |
| `Nia\Validation\ClosureValidator` | Validator using a closure. |
| `Nia\Validation\CompositeValidator` | Composite validators are used to combine multiple validators and use them as one. |
| `Nia\Validation\DateValidator` | Checks if the content is a valid date. |
| `Nia\Validation\EmailAddressValidator` | Checks if the content is a well formatted email address. |
| `Nia\Validation\InSetValidator` | Checks if the content is an allowed value. |
| `Nia\Validation\LengthValidator` | Checks if the length of the content is between a specific range. |
| `Nia\Validation\NullValidator` | Null validator object. |
| `Nia\Validation\NumberValidator` | Checks if the content is a valid number (integer). |
| `Nia\Validation\RangeValidator` | Checks if the content is between a specific range. |
| `Nia\Validation\RegexValidator` | Checks the content against a regex. |
| `Nia\Validation\TimeValidator` | Checks if the content is a valid time. |
| `Nia\Validation\UrlValidator` | Checks if the content is a well formatted url. |

## How to use
The following sample shows you how to use the `Nia\Validation\EmailAddressValidator`.

```php
	$validator = new EmailAddressValidator();
	$violations = $formatter->validate('foobar@my-super-cool-email-address.tld');
```
