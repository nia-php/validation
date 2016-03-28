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
use Nia\Validation\CompositeValidator;
use Nia\Validation\NullValidator;
use Nia\Validation\ClosureValidator;
use Nia\Validation\Violation\ViolationInterface;

/**
 * Unit test for \Nia\Validation\CompositeValidator.
 */
class CompositeValidatorTest extends PHPUnit_Framework_TestCase
{

    /**
     * @covers \Nia\Validation\CompositeValidator::validate
     */
    public function testValidate()
    {
        $violation = $this->getMock(ViolationInterface::class);

        $validator1 = new NullValidator();
        $validator2 = new ClosureValidator(function (string $content) use($violation) {
            return [
                $violation
            ];
        });
        $validator3 = new NullValidator();

        $validator = new CompositeValidator([
            $validator1,
            $validator2
        ]);

        $this->assertSame([
            $validator1,
            $validator2
        ], $validator->getValidators());

        $this->assertSame($validator, $validator->addValidator($validator3));

        $this->assertSame([
            $validator1,
            $validator2,
            $validator3
        ], $validator->getValidators());

        $this->assertSame([
            $violation
        ], $validator->validate('abc'));
    }
}

