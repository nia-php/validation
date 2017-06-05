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
use Nia\Validation\LengthValidator;
use Nia\Validation\Violation\Violation;
use Nia\Collection\Map\StringMap\Map;

/**
 * Unit test for \Nia\Validation\RangeValidator.
 */
class LengthValidatorTest extends TestCase
{

    /**
     * @covers \Nia\Validation\LengthValidator::validate
     * @dataProvider validateProvider
     */
    public function testValidate(int $min, int $max, string $content, array $expected)
    {
        $validator = new LengthValidator($min, $max);

        $this->assertEquals($expected, $validator->validate($content, new Map()));
    }

    public function validateProvider()
    {
        $_constant = function (string $value): string {
            return addslashes($value);
        };

        $content = <<<EOL
[
    [0, 8, "foo", []],
    [3, 4, "foo", []],
    [3, 4, "foob", []],
    [4, 8, "foo", [{"id":"{$_constant(LengthValidator::VIOLATION__TOO_SHORT)}", "message":"The content \"{{ content }}\" is to short, {{ min }} characters needed.", "context":{}}]],
    [4, 8, "foo bar baz", [{"id":"{$_constant(LengthValidator::VIOLATION__TOO_LONG)}", "message":"The content \"{{ content }}\" is to long, maximum is {{ max }} characters.", "context":{}}]]
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
