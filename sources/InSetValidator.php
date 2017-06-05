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

use Nia\Collection\Map\StringMap\Map;
use Nia\Collection\Map\StringMap\MapInterface;
use Nia\Validation\Violation\Violation;

/**
 * Checks if the content is an allowed value.
 */
class InSetValidator implements ValidatorInterface
{

    const VIOLATION__NOT_ALLOWED = self::class . ':not-allowed';

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
     * {@inheritdoc}
     *
     * @see \Nia\Validation\ValidatorInterface::validate($content, $context)
     */
    public function validate(string $content, MapInterface $context): array
    {
        $violations = [];
        $context = new Map([
            'content' => $content,
            'allowed-values' => implode(',', $this->values)
        ]);

        if (! in_array($content, $this->values, true)) {
            $violations[] = new Violation(self::VIOLATION__NOT_ALLOWED, 'The content "{{ content }}" is not an allowed value. Allowed values are {{ allowed-values }}.', $context);
        }

        return $violations;
    }
}

