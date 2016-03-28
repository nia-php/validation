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
use Nia\Validation\ClosureValidator;
use Nia\Validation\Violation\ViolationInterface;

/**
 * Unit test for \Nia\Validation\ClosureValidator.
 */
class ClosureValidatorTest extends PHPUnit_Framework_TestCase
{

    /**
     * @covers \Nia\Validation\ClosureValidator::validate
     */
    public function testValidate()
    {
        $violation = $this->getMock(ViolationInterface::class);

        $validator = new ClosureValidator(function (string $content) use($violation) {
            return [
                $violation
            ];
        });

        $this->assertSame([
            $violation
        ], $validator->validate('foo bar'));
    }
}

