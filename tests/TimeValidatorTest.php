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
use Nia\Validation\TimeValidator;
use Nia\Collection\Map\StringMap\Map;
use Nia\Validation\Violation\Violation;

/**
 * Unit test for \Nia\Validation\TimeValidator.
 */
class TimeValidatorTest extends TestCase
{

    /**
     * @covers \Nia\Validation\TimeValidator::validate
     * @dataProvider validateProvider
     */
    public function testValidate(string $content, array $expected)
    {
        $validator = new TimeValidator();

        $this->assertEquals($expected, $validator->validate($content, new Map()));
    }

    public function validateProvider()
    {
        $content = <<<EOL
[
    ["23:12:34", []],
    ["", [{"id":"time:empty", "message":"The content is empty.", "context":{}}]],
    ["24:56:78", [{"id":"time:invalid-time", "message":"The content \"{{ content }}\" is not a valid time.", "context":{}}]],
    ["00:00:60", [{"id":"time:invalid-time", "message":"The content \"{{ content }}\" is not a valid time.", "context":{}}]],
    ["a:b:c", [{"id":"time:invalid-format", "message":"The content \"{{ content }}\" is not a valid formatted time.", "context":{}}]]
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

