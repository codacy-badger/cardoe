<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Logger;

use Phalcon\Logger;

/**
 * PhalconNG\Logger\LoggerFactory
 *
 * @property AdapterFactory $adapterFactory
 */
class LoggerFactory
{
    /**
     * @var AdapterFactory
     */
    private $adapterFactory;

    /**
     * LoggerFactory constructor.
     *
     * @param AdapterFactory $factory
     */
    public function __construct(AdapterFactory $factory)
    {
        $this->adapterFactory = $factory;
    }

    /**
     * Returns a Logger object
     *
     * @param string $name
     * @param array  $adapters
     *
     * @return Logger
     */
    public function newInstance(string $name, array $adapters = []): Logger
    {
        return new Logger($name, $adapters);
    }
}
