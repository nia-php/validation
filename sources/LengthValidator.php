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
 * Checks if the length of the content is between a specific range.
 */
class LengthValidator implements ValidatorInterface
{

    /**
     * The min range.
     *
     * @var int
     */
    private $min = null;

    /**
     * The max range.
     *
     * @var int
     */
    private $max = null;

    /**
     * Constructor.
     *
     * @param int $min
     *            The min range.
     * @param int $max
     *            The max range.
     * @throws InvalidArgumentException If the passed max value is less than the passed min value.
     */
    public function __construct(int $min, int $max)
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

        $length = mb_strlen($content);

        if ($length < $this->min) {
            $violations[] = new Violation('length:to-short', 'The content "{{ content }}" is to short, {{ min }} characters needed.', $context);
        } elseif ($length > $this->max) {
            $violations[] = new Violation('length:to-long', 'The content "{{ content }}" is to long, maximum is {{ max }} characters.', $context);
        }

        return $violations;
    }
}

