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
 * Checks if the content is a valid time.
 */
class TimeValidator implements ValidatorInterface
{

    const VIOLATION__EMPTY = self::class . ':empty';

    const VIOLATION__FORMAT = self::class . ':format';

    const VIOLATION__TIME = self::class . ':time';

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
            $violations[] = new Violation(self::VIOLATION__EMPTY, 'The content is empty.', $context);
        } elseif (! preg_match('/^(?P<hour>\d{2}):(?P<minute>\d{2}):(?P<second>\d{2})$/', $content, $match)) {
            $violations[] = new Violation(self::VIOLATION__FORMAT, 'The content "{{ content }}" is not a valid formatted time.', $context);
        } elseif (! $this->checktime((int) $match['hour'], (int) $match['minute'], (int) $match['second'])) {
            $violations[] = new Violation(self::VIOLATION__TIME, 'The content "{{ content }}" is not a valid time.', $context);
        }

        return $violations;
    }

    /**
     * Checks whether the passed time is a valid time.
     *
     * @param int $hour
     *            The hour.
     * @param int $minute
     *            The minute.
     * @param int $second
     *            The second.
     * @return bool Returns 'true' if the passed time is a valid time, otherwise 'false' will be returned.
     */
    private function checktime(int $hour, int $minute, int $second)
    {
        if ($hour < 0 || $hour > 23) {
            return false;
        } elseif ($minute < 0 || $minute > 59) {
            return false;
        } elseif ($second < 0 || $second > 59) {
            return false;
        }

        return true;
    }
}
