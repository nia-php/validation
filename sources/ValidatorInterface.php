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
namespace Nia\Validation;

use Nia\Collection\Map\StringMap\MapInterface;
use Nia\Validation\Violation\ViolationInterface;

/**
 * Interface for validator implementations.
 * Validators are used to verify that content matches successfully against a condition.
 */
interface ValidatorInterface
{

    /**
     * Validates the passed content.
     *
     * @param string $content
     *            The content to validate.
     * @param MapInterface $context
     *            The context of the validation.
     * @return ViolationInterface[] List with violations. If the list is empty there is no violation occurred.
     */
    public function validate(string $content, MapInterface $context): array;
}
