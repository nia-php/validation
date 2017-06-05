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
 * Checks if the content is a well formatted email address.
 */
class EmailAddressValidator implements ValidatorInterface
{

    const VIOLATION__EMPTY = self::class . ':empty';

    const VIOLATION__FORMAT = self::class . ':format';

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

        if ($content === '') {
            $violations[] = new Violation(self::VIOLATION__EMPTY, 'The content is empty.', $context);
        } elseif (! filter_var($content, FILTER_VALIDATE_EMAIL)) {
            $violations[] = new Violation(self::VIOLATION__FORMAT, 'The content "{{ content }}" is not a well formatted email address.', $context);
        }

        return $violations;
    }
}

