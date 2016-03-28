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
use Nia\Validation\InSetValidator;
use Nia\Collection\Map\StringMap\Map;
use Nia\Validation\Violation\Violation;

/**
 * Unit test for \Nia\Validation\InSetValidator.
 */
class InSetValidatorTest extends PHPUnit_Framework_TestCase
{

    /**
     * @covers \Nia\Validation\InSetValidator::validate
     * @dataProvider validateProvider
     */
    public function testValidate(array $values, string $content, array $expected)
    {
        $validator = new InSetValidator($values);

        $this->assertEquals($expected, $validator->validate($content));
    }

    public function validateProvider()
    {
        $content = <<<EOL
[
    [["foo", "bar", "baz"], "foo", []],
    [["foo", "bar", "baz"], "bar", []],
    [["foo", "bar", "baz"], "baz", []],
    [["foo", "bar", "baz"], "foobar", [{"id":"in-set:not-allowed", "message":"The content \"{{ content }}\" is not an allowed value. Allowed values are {{ allowed-values }}.", "context":{"allowed-values":"foo,bar,baz"}}]],
    [[], "foobar", [{"id":"in-set:not-allowed", "message":"The content \"{{ content }}\" is not an allowed value. Allowed values are {{ allowed-values }}.", "context":{"allowed-values":""}}]]
]
EOL;

        $tests = [];

        foreach (json_decode($content, true) as $test) {
            $violations = [];

            foreach ($test[2] as $violation) {
                // "content" is always the first entry in the context.
                $violation['context'] = [
                    'content' => $test[1]
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
