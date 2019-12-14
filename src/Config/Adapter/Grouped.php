<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Config\Adapter;

use Phalcon\Config;
use Phalcon\Config\ConfigFactory;
use Phalcon\Config\Exception;
use Phalcon\Factory\Exception as ExceptionAlias;
use function is_array;
use function is_string;

class Grouped extends Config
{
    /**
     * Grouped constructor.
     *
     * @param array  $arrayConfig
     * @param string $defaultAdapter
     *
     * @throws Exception
     * @throws ExceptionAlias
     */
    public function __construct(array $arrayConfig, string $defaultAdapter = "php")
    {
        parent::__construct([]);

        foreach ($arrayConfig as $configName) {
            $configInstance = $configName;

            // Set to default adapter if passed as string
            if ($configName instanceof Config) {
                $this->merge($configInstance);
                continue;
            } elseif (is_string($configName)) {
                if ("" === $defaultAdapter) {
                    $this->merge(
                        (new ConfigFactory())->load($configName)
                    );

                    continue;
                }

                $configInstance = [
                    "filePath" => $configName,
                    "adapter"  => $defaultAdapter,
                ];
            } elseif (!isset($configInstance["adapter"])) {
                $configInstance["adapter"] = $defaultAdapter;
            }

            if (is_array($configInstance["adapter"])) {
                if (!isset($configInstance["config"])) {
                    throw new Exception(
                        "To use 'array' adapter you have to specify " .
                        "the 'config' as an array."
                    );
                }

                $configArray    = $configInstance["config"];
                $configInstance = new Config($configArray);
            } else {
                $configInstance = (new ConfigFactory())->load($configInstance);
            }

            $this->merge($configInstance);
        }
    }
}
