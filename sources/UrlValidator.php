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
 * Checks if the content is a well formatted url.
 */
class UrlValidator implements ValidatorInterface
{

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
            'content' => $content
        ]);

        if ($content === '') {
            $violations[] = new Violation('url:empty', 'The content is empty.', $context);
        } elseif (! filter_var($content, FILTER_VALIDATE_URL)) {
            $violations[] = new Violation('url:invalid-format', 'The content "{{ content }}" is not a well formatted URL.', $context);
        }

        return $violations;
    }
}
