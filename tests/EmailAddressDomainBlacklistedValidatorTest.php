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
use Nia\Validation\Violation\Violation;
use Nia\Collection\Map\StringMap\Map;
use Nia\Validation\EmailAddressDomainBlacklistedValidator;

/**
 * Unit test for \Nia\Validation\EmailAddressDomainBlacklistedValidatorTest.
 */
class EmailAddressDomainBlacklistedValidatorTest extends TestCase
{

    /**
     * @covers \Nia\Validation\EmailAddressDomainBlacklistedValidatorTest::validate
     * @dataProvider validateProvider
     */
    public function testValidate(string $content, array $blacklistedDomains, array $expected)
    {
        $validator = new EmailAddressDomainBlacklistedValidator($blacklistedDomains);

        $this->assertEquals($expected, $validator->validate($content, new Map()));
    }

    public function validateProvider()
    {
        $_constant = function (string $value): string {
            return addslashes($value);
        };

        $content = <<<EOL
[
    ["foo@my-high-quality-and-cool-email-address.org", [], []],
    ["", [], [{"id":"{$_constant(EmailAddressDomainBlacklistedValidator::VIOLATION__EMPTY)}", "message":"The content is empty.", "context":{}}]],
    ["bla@bla--bla.org", ["bla--bla.org"], [{"id":"{$_constant(EmailAddressDomainBlacklistedValidator::VIOLATION__BLACKLISTED)}", "message":"The domain of \"{{ content }}\" is blacklisted.", "context":{}}]]
]
EOL;

        $tests = [];

        foreach (json_decode($content, true) as $test) {
            $violations = [];

            foreach ($test[2] as $violation) {
                // "content" is always the first entry in the context.
                $violation['context'] = [
                    'content' => $test[0]
                ] + $violation['context'];

                $violations[] = new Violation($violation['id'], $violation['message'], new Map($violation['context']));
            }

            $tests[] = [
                $test[0],
                $test[1],
                $violations
            ];
        }

        return $tests;
    }
}
