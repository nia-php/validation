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
| `Nia\Validation\DateTimeValidator` | Checks if the content is a valid date time. |
| `Nia\Validation\DateValidator` | Checks if the content is a valid date. |
| `Nia\Validation\EmailAddressValidator` | Checks if the content is a well formatted email address. |
| `Nia\Validation\EmailAddressDomainBlacklistedValidator` | Checks if the email address domain is blacklisted. |
| `Nia\Validation\InSetValidator` | Checks if the content is an allowed value. |
| `Nia\Validation\IpV4AddressValidator` | Checks if the content is a valid IPv4 address. |
| `Nia\Validation\IpV6AddressValidator` | Checks if the content is a valid IPv6 address. |
| `Nia\Validation\LengthValidator` | Checks if the length of the content is between a specific range. |
| `Nia\Validation\NullValidator` | Null validator object. |
| `Nia\Validation\NumberValidator` | Checks if the content is a valid number (integer). |
| `Nia\Validation\OrCompositeValidator` | Logical OR composite validator is used to combine multiple validators and use them as one. If one inner validator is successfull the entire composite is successfully. |
| `Nia\Validation\RangeValidator` | Checks if the content is between a specific range. |
| `Nia\Validation\RegexValidator` | Checks the content against a regex. |
| `Nia\Validation\TimeValidator` | Checks if the content is a valid time. |
| `Nia\Validation\UrlValidator` | Checks if the content is a well formatted url. |

## Conditional Validators
The component also provides conditional validators which are used to execute a decorated validator only if a condition is true. You are also able to write your own conditional validator by implementing the `Nia\Validation\Condition\ConditionValidatorInterface` interface.

| Validator | Description |
| --- | --- |
| `Nia\Validation\Condition\ClosureConditionValidator` | Validator using a closure to determine whether the decorated validator is allowed to execute. |

## How to use
The following sample shows you how to use the `Nia\Validation\EmailAddressValidator`.

```php
	$validator = new EmailAddressValidator();
	$violations = $formatter->validate('foobar@my-super-cool-email-address.tld', new Map());
```
