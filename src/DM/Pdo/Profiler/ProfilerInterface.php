<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 *
 * Implementation of this file has been influenced by AtlasPHP
 *
 * @link    https://github.com/atlasphp/Atlas.Pdo
 * @license https://github.com/atlasphp/Atlas.Pdo/blob/1.x/LICENSE.md
 */

declare(strict_types=1);

namespace Cardoe\DM\Pdo\Profiler;

use Psr\Log\LoggerInterface;

/**
 * Interface to send query profiles to a logger.
 */
interface ProfilerInterface
{
    /**
     * Finishes and logs a profile entry.
     *
     * @param string $statement The statement being profiled, if any.
     * @param array  $values    The values bound to the statement, if any.
     */
    public function finish(string $statement = null, array $values = []): void;

    /**
     * Returns the underlying logger instance.
     *
     * @return LoggerInterface
     */
    public function getLogger(): LoggerInterface;

    /**
     * Returns the log message format string, with placeholders.
     *
     * @return string
     */
    public function getLogFormat(): string;

    /**
     * Returns the level at which to log profile messages.
     *
     * @return string
     */
    public function getLogLevel(): string;

    /**
     * Returns true if logging is active.
     *
     * @return bool
     */
    public function isActive(): bool;

    /**
     * Enable or disable profiler logging.
     *
     * @param bool $active
     *
     * @return ProfilerInterface
     */
    public function setActive(bool $active): ProfilerInterface;

    /**
     * Sets the log message format string, with placeholders.
     *
     * @param string $logFormat
     *
     * @return ProfilerInterface
     */
    public function setLogFormat(string $logFormat): ProfilerInterface;

    /**
     * Level at which to log profile messages.
     *
     * @param string $logLevel A PSR LogLevel constant.
     *
     * @return ProfilerInterface
     *
     */
    public function setLogLevel(string $logLevel): ProfilerInterface;

    /**
     * Starts a profile entry.
     *
     * @param string $method The method starting the profile entry.
     */
    public function start(string $method): void;
}