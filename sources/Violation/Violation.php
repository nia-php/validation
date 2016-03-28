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
namespace Nia\Validation\Violation;

use Nia\Collection\Map\StringMap\MapInterface;

/**
 * Default violation implementation.
 */
class Violation implements ViolationInterface
{

    /**
     * The violation id.
     *
     * @var string
     */
    private $id = null;

    /**
     * The violation message.
     *
     * @var string
     */
    private $message = null;

    /**
     * The violation context.
     *
     * @var MapInterface
     */
    private $context = null;

    /**
     * Constructor.
     *
     * @param string $id
     *            The violation identifier.
     * @param string $message
     *            The violation message.
     * @param MapInterface $context
     *            The violation context.
     */
    public function __construct(string $id, string $message, MapInterface $context)
    {
        $this->id = $id;
        $this->message = $message;
        $this->context = $context;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\Validation\Violation\ViolationInterface::getId()
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\Validation\Violation\ViolationInterface::getMessage()
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\Validation\Violation\ViolationInterface::getContext()
     */
    public function getContext(): MapInterface
    {
        return $this->context;
    }
}

