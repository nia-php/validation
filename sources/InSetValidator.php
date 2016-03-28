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

use Nia\Validation\Violation\Violation;
use Nia\Collection\Map\StringMap\Map;

/**
 * Checks if the content is an allowed value.
 */
class InSetValidator implements ValidatorInterface
{

    /**
     * List with allowed values.
     *
     * @var string[]
     */
    private $values = [];

    /**
     * Constructor.
     *
     * @param string[] $values
     *            List with allowed values.
     */
    public function __construct(array $values)
    {
        $this->values = $values;
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
        $context = new Map([
            'content' => $content,
            'allowed-values' => implode(',', $this->values)
        ]);

        if (! in_array($content, $this->values, true)) {
            $violations[] = new Violation('in-set:not-allowed', 'The content "{{ content }}" is not an allowed value. Allowed values are {{ allowed-values }}.', $context);
        }

        return $violations;
    }
}

