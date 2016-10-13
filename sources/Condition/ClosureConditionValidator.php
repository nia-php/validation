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

use Closure;
use Nia\Collection\Map\StringMap\MapInterface;
use Nia\Validation\ValidatorInterface;

/**
 * Condition validator using a closure to determine whether the decorated validator is allowed to execute.
 */
class ClosureConditionValidator implements ConditionValidatorInterface
{

    /**
     * Closure which is used for the conditional check.
     *
     * @var Closure
     */
    private $condition = null;

    /**
     * The validator to decorated.
     *
     * @var ValidatorInterface
     */
    private $validator = null;

    /**
     * Constructor.
     *
     * @param Closure $condition
     *            Closure which is used for the conditional check. If the closure returns 'true' the decorated validator will be executed.
     * @param ValidatorInterface $validator
     *            The validator to decorated.
     */
    public function __construct(Closure $condition, ValidatorInterface $validator)
    {
        $this->condition = $condition;
        $this->validator = $validator;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Nia\Validation\ValidatorInterface::validate()
     */
    public function validate(string $content, MapInterface $context): array
    {
        $condition = $this->condition;

        if ($condition($content, $context)) {
            return $this->validator->validate($content, $context);
        }

        return [];
    }
}
