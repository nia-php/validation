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
 * Checks if the content is a well formatted IPv6 address.
 */
class IpV6AddressValidator implements ValidatorInterface
{

    const VIOLATION__EMPTY = self::class . ':empty';

    const VIOLATION__FORMAT = self::class . ':format';

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

        if ($content === '') {
            $violations[] = new Violation(self::VIOLATION__EMPTY, 'The content is empty.', $context);
        } elseif (! filter_var($content, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $violations[] = new Violation(self::VIOLATION__FORMAT, 'The content "{{ content }}" is not a well formatted IPv6 address.', $context);
        }

        return $violations;
    }
}

