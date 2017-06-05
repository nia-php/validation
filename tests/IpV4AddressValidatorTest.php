<?php
/*
 * This file is part of the nia framework architecture.
 *
 * (c) Patrick Ullmann <patrick.ullmann@nat-software.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types = 1);
namespace Test\Nia\Validation;

use PHPUnit\Framework\TestCase;
use Nia\Validation\IpV4AddressValidator;
use Nia\Validation\Violation\Violation;
use Nia\Collection\Map\StringMap\Map;

/**
 * Unit test for \Nia\Validation\IpV4AddressValidator.
 */
class IpV4AddressValidatorTest extends TestCase
{

    /**
     * @covers \Nia\Validation\IpV4AddressValidator::validate
     * @dataProvider validateProvider
     */
    public function testValidate(string $content, array $expected)
    {
        $validator = new IpV4AddressValidator();

        $this->assertEquals($expected, $validator->validate($content, new Map()));
    }

    public function validateProvider()
    {
        $_constant = function (string $value): string {
            return addslashes($value);
        };

        $content = <<<EOL
[
    ["127.0.0.1", []],
    ["0.0.0.0", []],
    ["192.168.1.1", []],
    ["", [{"id":"{$_constant(IpV4AddressValidator::VIOLATION__EMPTY)}", "message":"The content is empty.", "context":{}}]],
    ["256.256.256.256", [{"id":"{$_constant(IpV4AddressValidator::VIOLATION__FORMAT)}", "message":"The content \"{{ content }}\" is not a well formatted IPv4 address.", "context":{}}]],
    ["aaaa", [{"id":"{$_constant(IpV4AddressValidator::VIOLATION__FORMAT)}", "message":"The content \"{{ content }}\" is not a well formatted IPv4 address.", "context":{}}]]
]
EOL;

        $tests = [];

        foreach (json_decode($content, true) as $test) {
            $violations = [];

            foreach ($test[1] as $violation) {
                // "content" is always the first entry in the context.
                $violation['context'] = [
                    'content' => $test[0]
                ] + $violation['context'];

                $violations[] = new Violation($violation['id'], $violation['message'], new Map($violation['context']));
            }

            $tests[] = [
                $test[0],
                $violations
            ];
        }

        return $tests;
    }
}
