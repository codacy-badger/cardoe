<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 *
 * Implementation of this file has been influenced by cardoe-api and AuraPHP
 *
 * @link    https://github.com/cardoe/cardoe-api
 * @license https://github.com/cardoe/cardoe-api/blob/master/LICENSE
 * @link    https://github.com/auraphp/Aura.Payload
 * @license https://github.com/auraphp/Aura.Payload/blob/3.x/LICENSE
 *
 * @see     Original inspiration for the https://github.com/cardoe/cardoe-api
 */

declare(strict_types=1);

namespace Cardoe\Domain\Payload;

use Throwable;

/**
 * Cardoe\Domain\Payload\Payload
 *
 * Holds the payload
 */
class Payload implements PayloadInterface
{
    /**
     * Exception if any
     *
     * @$Throwable
     */
    protected $exception;

    /**
     * Extra information
     *
     * @$mixed
     */
    protected $extras;

    /**
     * Input
     *
     * @$mixed
     */
    protected $input;

    /**
     * Messages
     *
     * @$mixed
     */
    protected $messages;

    /**
     * Status
     *
     * @$mixed
     */
    protected $status;

    /**
     * Output
     *
     * @$mixed
     */
    protected $output;

    /**
     * @return Throwable
     */
    public function getException(): Throwable
    {
        return $this->exception;
    }

    /**
     * @return mixed
     */
    public function getExtras()
    {
        return $this->extras;
    }

    /**
     * @return mixed
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * @return mixed
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * @return mixed
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Sets an exception thrown in the domain
     *
     * @param Throwable $exception
     *
     * @return PayloadInterface
     */
    public function setException(Throwable $exception): PayloadInterface
    {
        $this->exception = $exception;

        return $this;
    }

    /**
     * Sets arbitrary extra domain information.
     *
     * @param mixed $extras
     *
     * @return PayloadInterface
     */
    public function setExtras($extras): PayloadInterface
    {
        $this->extras = $extras;

        return $this;
    }

    /**
     * Sets the domain input.
     *
     * @param mixed $input
     *
     * @return PayloadInterface
     */
    public function setInput($input): PayloadInterface
    {
        $this->input = $input;

        return $this;
    }

    /**
     * Sets the domain messages.
     *
     * @param mixed $messages
     *
     * @return PayloadInterface
     */
    public function setMessages($messages): PayloadInterface
    {
        $this->messages = $messages;

        return $this;
    }

    /**
     * Sets the domain output.
     *
     * @param mixed $output
     *
     * @return PayloadInterface
     */
    public function setOutput($output): PayloadInterface
    {
        $this->output = $output;

        return $this;
    }

    /**
     * Sets the payload status.
     *
     * @param mixed $status
     *
     * @return PayloadInterface
     */
    public function setStatus($status): PayloadInterface
    {
        $this->status = $status;

        return $this;
    }
}
