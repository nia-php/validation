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
 * Checks if the content is a valid date time.
 */
class DateTimeValidator implements ValidatorInterface
{

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
            'content' => $content
        ]);

        $match = [];

        if ($content === '') {
            $violations[] = new Violation('date-time:empty', 'The content is empty.', $context);
        } elseif (! preg_match('/^(?P<year>\d{4})-(?P<month>\d{2})-(?P<day>\d{2}) (?P<hour>[0-2][0-9]):(?P<minute>[0-5][0-9]):(?P<second>[0-5][0-9])$/', $content, $match)) {
            $violations[] = new Violation('date-time:invalid-format', 'The content "{{ content }}" is not a valid formatted date time.', $context);
        } elseif (! checkdate((int) $match['month'], (int) $match['day'], (int) $match['year'])) {
            $violations[] = new Violation('date-time:invalid-date', 'The content "{{ content }}" contains an invalid date.', $context);
        } elseif ((int) $match['hour'] >= 24 || (int) $match['minute'] >= 60 || (int) $match['second'] >= 60) {
            $violations[] = new Violation('date-time:invalid-time', 'The content "{{ content }}" contains an invalid time.', $context);
        }

        return $violations;
    }
}
