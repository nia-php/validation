<?php
declare(strict_types = 1);
namespace Nia\Validation;

use Nia\Collection\Map\StringMap\Map;
use Nia\Collection\Map\StringMap\MapInterface;
use Nia\Validation\Violation\Violation;
use Nia\Validation\ValidatorInterface;

/**
 * Checks if the content contains a blacklisted email address domain.
 */
class EmailAddressDomainBlacklistedValidator implements ValidatorInterface
{

    const VIOLATION__EMPTY = self::class . ':empty';

    const VIOLATION__BLACKLISTED = self::class . ':blacklisted';

    /**
     * List with blacklisted domains.
     *
     * @var string[]
     */
    private $blacklistedDomains = [];

    /**
     * Constructor.
     *
     * @param string[] $blacklistedDomains
     *            List with blacklisted domains.
     */
    public function __construct(array $blacklistedDomains)
    {
        $this->blacklistedDomains = $blacklistedDomains;
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
            'content' => $content
        ]);

        list ($name, $domain) = explode('@', $content, 2) + array_fill(0, 2, '');

        if ($content === '') {
            $violations[] = new Violation(self::VIOLATION__EMPTY, 'The content is empty.', $context);
        } elseif (in_array(mb_strtolower($domain), $this->blacklistedDomains)) {
            $violations[] = new Violation(self::VIOLATION__BLACKLISTED, 'The domain of "{{ content }}" is blacklisted.', $context);
        }

        return $violations;
    }
}
