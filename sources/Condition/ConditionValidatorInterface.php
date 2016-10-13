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
namespace Nia\Validation\Condition;

use Nia\Validation\ValidatorInterface;

/**
 * Interface for conditional validator implementations.
 * Condition validators are containing a validator which is only executed if a condition is true.
 */
interface ConditionValidatorInterface extends ValidatorInterface
{
}
