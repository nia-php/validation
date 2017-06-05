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
use Nia\Validation\OrCompositeValidator;
use Nia\Validation\NullValidator;
use Nia\Validation\ClosureValidator;
use Nia\Validation\Violation\ViolationInterface;
use Nia\Collection\Map\StringMap\MapInterface;

/**
 * Unit test for \Nia\Validation\OrCompositeValidator.
 */
class OrCompositeValidatorTest extends TestCase
{

    /**
     * @covers \Nia\Validation\OrCompositeValidator::validate
     */
    public function testValidate()
    {
        $violation = $this->createMock(ViolationInterface::class);
        $context = $this->createMock(MapInterface::class);

        $validator1 = new ClosureValidator(function (string $content, MapInterface $context) use ($violation) {
            return [
                $violation
            ];
        });
        $validator2 = new NullValidator();

        $validator = new OrCompositeValidator([
            $validator1
        ]);

        $this->assertSame([
            $validator1
        ], $validator->getValidators());

        $this->assertSame([
            $violation
        ], $validator->validate('abc', $context));

        $this->assertSame($validator, $validator->addValidator($validator2));

        $this->assertSame([
            $validator1,
            $validator2
        ], $validator->getValidators());

        $this->assertSame([], $validator->validate('abc', $context));
    }
}
