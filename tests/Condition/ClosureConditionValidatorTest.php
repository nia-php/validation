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
namespace Test\Nia\Validation\Condition;

use PHPUnit\Framework\TestCase;
use Nia\Validation\ClosureValidator;
use Nia\Validation\Violation\ViolationInterface;
use Nia\Collection\Map\StringMap\MapInterface;
use Nia\Collection\Map\StringMap\Map;
use Nia\Validation\Condition\ClosureConditionValidator;

/**
 * Unit test for \Nia\Validation\Condition\ClosureConditionValidator.
 */
class ClosureConditionValidatorTest extends TestCase
{

    /**
     * @covers \Nia\Validation\Condition\ClosureConditionValidator::validate
     */
    public function testValidate()
    {
        $violation = $this->createMock(ViolationInterface::class);

        $validator = new ClosureValidator(function (string $content, MapInterface $context) use ($violation) {
            return [
                $violation
            ];
        });

        // allowed to execute.
        $conditionValidator = new ClosureConditionValidator(function (string $content, MapInterface $context) {
            return true;
        }, $validator);

        $this->assertSame([
            $violation
        ], $conditionValidator->validate('foo bar', new Map()));

        // disallowed to execute.
        $conditionValidator = new ClosureConditionValidator(function (string $content, MapInterface $context) {
            return false;
        }, $validator);

        $this->assertSame([], $conditionValidator->validate('foo bar', new Map()));
    }
}

