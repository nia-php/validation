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

/**
 * Interface for composite validator implementations.
 * Composite validators are used to combine multiple validators and use them as one.
 */
interface CompositeValidatorInterface extends ValidatorInterface
{

    /**
     * Adds a validator.
     *
     * @param ValidatorInterface $validator
     *            The validator to add.
     * @return CompositeValidatorInterface Reference to this instance.
     */
    public function addValidator(ValidatorInterface $validator): CompositeValidatorInterface;

    /**
     * Returns a list of all assigned validators.
     *
     * @return ValidatorInterface[] List of all assigned validators.
     */
    public function getValidators(): array;
}

