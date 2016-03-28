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
use Nia\Validation\RegexValidator;
use Nia\Validation\Violation\Violation;
use Nia\Collection\Map\StringMap\Map;

/**
 * Unit test for \Nia\Validation\RegexValidator.
 */
class RegexValidatorTest extends PHPUnit_Framework_TestCase
{

    /**
     * @covers \Nia\Validation\RegexValidator::validate
     * @dataProvider validateProvider
     */
    public function testValidate(string $regex, string $content, string $violationId, string $violationMessage, array $expected)
    {
        $validator = new RegexValidator($regex, $violationId, $violationMessage);

        $this->assertEquals($expected, $validator->validate($content));
    }

    public function validateProvider()
    {
        $content = <<<EOL
[
    ["/^\\\\d+$/", "123", "", "", []],
    ["/^\\\\d+$/", "foobar", "my-id", "my-message", [{"id":"my-id", "message":"my-message", "context":{}}]]
]
EOL;

        $tests = [];

        foreach (json_decode($content, true) as $test) {
            $violations = [];

            foreach ($test[4] as $violation) {
                // "content" is always the first entry in the context.
                $violation['context'] = [
                    'content' => $test[1],
                    'regex' => $test[0]
                ] + $violation['context'];

                $violations[] = new Violation($violation['id'], $violation['message'], new Map($violation['context']));
            }

            $tests[] = [
                $test[0],
                $test[1],
                $test[2],
                $test[3],
                $violations
            ];
        }

        return $tests;
    }
}
