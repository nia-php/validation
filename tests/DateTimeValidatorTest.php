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
use Nia\Validation\DateTimeValidator;
use Nia\Validation\Violation\Violation;
use Nia\Collection\Map\StringMap\Map;

/**
 * Unit test for \Nia\Validation\DateTimeValidator.
 */
class DateTimeValidatorTest extends TestCase
{

    /**
     * @covers \Nia\Validation\DateTimeValidator::validate
     * @dataProvider validateProvider
     */
    public function testValidate(string $content, array $expected)
    {
        $validator = new DateTimeValidator();

        $this->assertEquals($expected, $validator->validate($content, new Map()));
    }

    public function validateProvider()
    {
        $content = <<<EOL
[
    ["2016-01-30 23:59:59", []],
    ["", [{"id":"date-time:empty", "message":"The content is empty.", "context":{}}]],
    ["2015-08-32 23:59:59", [{"id":"date-time:invalid-date", "message":"The content \"{{ content }}\" contains an invalid date.", "context":{}}]],
    ["2015-02-29 23:59:59", [{"id":"date-time:invalid-date", "message":"The content \"{{ content }}\" contains an invalid date.", "context":{}}]],
    ["2015-07-15 24:00:00", [{"id":"date-time:invalid-time", "message":"The content \"{{ content }}\" contains an invalid time.", "context":{}}]],
    ["2015-07-15 23:60:61", [{"id":"date-time:invalid-format", "message":"The content \"{{ content }}\" is not a valid formatted date time.", "context":{}}]],
    ["a-b-c", [{"id":"date-time:invalid-format", "message":"The content \"{{ content }}\" is not a valid formatted date time.", "context":{}}]],
    ["20160101", [{"id":"date-time:invalid-format", "message":"The content \"{{ content }}\" is not a valid formatted date time.", "context":{}}]],
    ["2016/01/01", [{"id":"date-time:invalid-format", "message":"The content \"{{ content }}\" is not a valid formatted date time.", "context":{}}]]
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

