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
 * Composite validator implementation.
 */
class CompositeValidator implements CompositeValidatorInterface
{

    /**
     * List with assigned validators.
     *
     * @var ValidatorInterface[]
     */
    private $validators = [];

    /**
     * Constructor.
     *
     * @param ValidatorInterface[] $validators
     *            List with validators to assign.
     */
    public function __construct(array $validators = [])
    {
        foreach ($validators as $validator) {
            $this->addValidator($validator);
        }
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\Validation\ValidatorInterface::validate($content)
     */
    public function validate(string $content): array
    {
        $violations = [];

        foreach ($this->validators as $validator) {
            $violations = array_merge($violations, $validator->validate($content));
        }

        return $violations;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\Validation\CompositeValidatorInterface::addValidator($validator)
     */
    public function addValidator(ValidatorInterface $validator): CompositeValidatorInterface
    {
        $this->validators[] = $validator;

        return $this;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\Validation\CompositeValidatorInterface::getValidators()
     */
    public function getValidators(): array
    {
        return $this->validators;
    }
}

