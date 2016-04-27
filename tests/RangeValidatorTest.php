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
use Nia\Validation\RangeValidator;
use Nia\Collection\Map\StringMap\Map;
use Nia\Validation\Violation\Violation;

/**
 * Unit test for \Nia\Validation\RangeValidator.
 */
class RangeValidatorTest extends PHPUnit_Framework_TestCase
{

    /**
     * @covers \Nia\Validation\RangeValidator::validate
     * @dataProvider validateProvider
     */
    public function testValidate(float $min, float $max, string $content, array $expected)
    {
        $validator = new RangeValidator($min, $max);

        $this->assertEquals($expected, $validator->validate($content, new Map()));
    }

    public function validateProvider()
    {
        $content = <<<EOL
[
    [0, 8, "3", []],
    [3, 4, "3.14", []],
    [0, 8, "9", [{"id":"range:out-of-range", "message":"The content \"{{ content }}\" is not between {{ min }} and {{ max }}.", "context":{}}]],
    [0, 8, "8.1", [{"id":"range:out-of-range", "message":"The content \"{{ content }}\" is not between {{ min }} and {{ max }}.", "context":{}}]]
]
EOL;

        $tests = [];

        foreach (json_decode($content, true) as $test) {
            $violations = [];

            foreach ($test[3] as $violation) {
                // "content" is always the first entry in the context.
                $violation['context'] = [
                    'content' => $test[2],
                    'min' => (string) $test[0],
                    'max' => (string) $test[1]
                ] + $violation['context'];

                $violations[] = new Violation($violation['id'], $violation['message'], new Map($violation['context']));
            }

            $tests[] = [
                $test[0],
                $test[1],
                $test[2],
                $violations
            ];
        }

        return $tests;
    }
}
