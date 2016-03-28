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
namespace Test\Nia\Validation\Violation;

use PHPUnit_Framework_TestCase;
use Nia\Validation\Violation\Violation;
use Nia\Collection\Map\StringMap\Map;

/**
 * Unit test for \Nia\Validation\Violation\Violation.
 */
class ViolationTest extends PHPUnit_Framework_TestCase
{

    /**
     * @covers \Nia\Validation\Violation\Violation
     */
    public function testMethods()
    {
        $id = 'foobar';
        $message = 'foo bar baz';
        $context = new Map();

        $instance = new Violation($id, $message, $context);

        $this->assertSame($id, $instance->getId());
        $this->assertSame($message, $instance->getMessage());
        $this->assertSame($context, $instance->getContext());
    }
}

