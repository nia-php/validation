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
 * Checks the content against a regex.
 */
class RegexValidator implements ValidatorInterface
{

    /**
     * The regex.
     *
     * @var string
     */
    private $regex = null;

    /**
     * The violation identifier.
     *
     * @var string
     */
    private $violationId = null;

    /**
     * The violation message.
     *
     * @var string
     */
    private $violationMessage = null;

    /**
     * Constructor.
     *
     * @param string $regex
     *            The regex.
     * @param string $violationId
     *            The violation identifier.
     * @param string $violationMessage
     *            The violation message.
     */
    public function __construct(string $regex, string $violationId, string $violationMessage)
    {
        $this->regex = $regex;
        $this->violationId = $violationId;
        $this->violationMessage = $violationMessage;
    }

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
            'content' => $content,
            'regex' => $this->regex
        ]);

        if (! preg_match($this->regex, $content)) {
            $violations[] = new Violation($this->violationId, $this->violationMessage, $context);
        }

        return $violations;
    }
}

