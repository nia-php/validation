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
use Nia\Validation\NullValidator;
use Nia\Collection\Map\StringMap\Map;

/**
 * Unit test for \Nia\Validation\NullValidator.
 */
class NullValidatorTest extends TestCase
{

    /**
     * @covers \Nia\Validation\NullValidator::validate
     */
    public function testValidate()
    {
        $validator = new NullValidator();

        $this->assertSame([], $validator->validate('foo bar', new Map()));
    }
}

