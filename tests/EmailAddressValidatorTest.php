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

use PHPUnit_Framework_TestCase;
use Nia\Validation\EmailAddressValidator;
use Nia\Validation\Violation\Violation;
use Nia\Collection\Map\StringMap\Map;

/**
 * Unit test for \Nia\Validation\EmailAddressValidator.
 */
class EmailAddressValidatorTest extends PHPUnit_Framework_TestCase
{

    /**
     * @covers \Nia\Validation\EmailAddressValidator::validate
     * @dataProvider validateProvider
     */
    public function testValidate(string $content, array $expected)
    {
        $validator = new EmailAddressValidator();

        $this->assertEquals($expected, $validator->validate($content));
    }

    public function validateProvider()
    {
        $content = <<<EOL
[
    ["foo@my-high-quality-and-cool-email-address.org", []],
    ["", [{"id":"email-address:empty", "message":"The content is empty.", "context":{}}]],
    ["bla@bla@bla.org", [{"id":"email-address:invalid-format", "message":"The content \"{{ content }}\" is not a well formatted email address.", "context":{}}]]
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
