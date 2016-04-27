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

use InvalidArgumentException;
use Nia\Collection\Map\StringMap\Map;
use Nia\Collection\Map\StringMap\MapInterface;
use Nia\Validation\Violation\Violation;

/**
 * Checks if the content is between a specific range.
 */
class RangeValidator implements ValidatorInterface
{

    /**
     * The min range.
     *
     * @var float
     */
    private $min = null;

    /**
     * The max range.
     *
     * @var float
     */
    private $max = null;

    /**
     * Constructor.
     *
     * @param float $min
     *            The min range.
     * @param float $max
     *            The max range.
     * @throws InvalidArgumentException If the passed max value is less than the passed min value.
     */
    public function __construct(float $min, float $max)
    {
        if ($max < $min) {
            throw new InvalidArgumentException('Max value is less the min value.');
        }

        $this->min = $min;
        $this->max = $max;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\Validation\ValidatorInterface::validate($content, $context)
     */
    public function validate(string $content, MapInterface $context): array
    {
        $violations = [];
        $context = new Map([
            'content' => $content,
            'min' => (string) $this->min,
            'max' => (string) $this->max
        ]);

        $content = (float) $content;

        if ($content < $this->min || $content > $this->max) {
            $violations[] = new Violation('range:out-of-range', 'The content "{{ content }}" is not between {{ min }} and {{ max }}.', $context);
        }

        return $violations;
    }
}

