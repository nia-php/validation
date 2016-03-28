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
 * Interface for violation implementation.
 * Implementations of this interface describe the violation of a failed validation.
 */
interface ViolationInterface
{

    /**
     * Returns the violation id.
     *
     * @return string The violation id.
     */
    public function getId(): string;

    /**
     * Returns the violation message.
     *
     * @return string The violation message.
     */
    public function getMessage(): string;

    /**
     * Returns the violation context.
     *
     * @return MapInterface The violation context.
     */
    public function getContext(): MapInterface;
}

