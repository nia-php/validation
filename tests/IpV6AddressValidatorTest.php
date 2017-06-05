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
use Nia\Validation\IpV6AddressValidator;
use Nia\Validation\Violation\Violation;
use Nia\Collection\Map\StringMap\Map;

/**
 * Unit test for \Nia\Validation\IpV6AddressValidator.
 */
class IpV6AddressValidatorTest extends TestCase
{

    /**
     * @covers \Nia\Validation\IpV6AddressValidator::validate
     * @dataProvider validateProvider
     */
    public function testValidate(string $content, array $expected)
    {
        $validator = new IpV6AddressValidator();

        $this->assertEquals($expected, $validator->validate($content, new Map()));
    }

    public function validateProvider()
    {
        $_constant = function (string $value): string {
            return addslashes($value);
        };

        $content = <<<EOL
[
    ["::1", []],
    ["fe00::0", []],
    ["ff02::2", []],
    ["2001:0db8:85a3:08d3:1319:8a2e:0370:7334", []],
    ["", [{"id":"{$_constant(IpV6AddressValidator::VIOLATION__EMPTY)}", "message":"The content is empty.", "context":{}}]],
    ["256.256.256.256", [{"id":"{$_constant(IpV6AddressValidator::VIOLATION__FORMAT)}", "message":"The content \"{{ content }}\" is not a well formatted IPv6 address.", "context":{}}]],
    ["aaaa", [{"id":"{$_constant(IpV6AddressValidator::VIOLATION__FORMAT)}", "message":"The content \"{{ content }}\" is not a well formatted IPv6 address.", "context":{}}]]
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
