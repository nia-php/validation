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
use Nia\Validation\DateValidator;
use Nia\Validation\Violation\Violation;
use Nia\Collection\Map\StringMap\Map;

/**
 * Unit test for \Nia\Validation\DateValidator.
 */
class DateValidatorTest extends PHPUnit_Framework_TestCase
{

    /**
     * @covers \Nia\Validation\DateValidator::validate
     * @dataProvider validateProvider
     */
    public function testValidate(string $content, array $expected)
    {
        $validator = new DateValidator();

        $this->assertEquals($expected, $validator->validate($content));
    }

    public function validateProvider()
    {
        $content = <<<EOL
[
    ["2016-01-30", []],
    ["", [{"id":"date:empty", "message":"The content is empty.", "context":{}}]],
    ["2015-08-32", [{"id":"date:invalid-date", "message":"The content \"{{ content }}\" is not a valid date.", "context":{}}]],
    ["2015-02-29", [{"id":"date:invalid-date", "message":"The content \"{{ content }}\" is not a valid date.", "context":{}}]],
    ["a-b-c", [{"id":"date:invalid-format", "message":"The content \"{{ content }}\" is not a valid formatted date.", "context":{}}]],
    ["20160101", [{"id":"date:invalid-format", "message":"The content \"{{ content }}\" is not a valid formatted date.", "context":{}}]],
    ["2016/01/01", [{"id":"date:invalid-format", "message":"The content \"{{ content }}\" is not a valid formatted date.", "context":{}}]]
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

