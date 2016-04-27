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
 * Checks if the content is a valid date.
 */
class DateValidator implements ValidatorInterface
{

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
            'content' => $content
        ]);

        $match = [];

        if ($content === '') {
            $violations[] = new Violation('date:empty', 'The content is empty.', $context);
        } elseif (! preg_match('/^(?P<year>\d{4})-(?P<month>\d{2})-(?P<day>\d{2})$/', $content, $match)) {
            $violations[] = new Violation('date:invalid-format', 'The content "{{ content }}" is not a valid formatted date.', $context);
        } elseif (! checkdate((int) $match['month'], (int) $match['day'], (int) $match['year'])) {
            $violations[] = new Violation('date:invalid-date', 'The content "{{ content }}" is not a valid date.', $context);
        }

        return $violations;
    }
}

