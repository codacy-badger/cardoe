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

namespace Phalcon\Config\Adapter;

use Phalcon\Config;
use Phalcon\Config\Exception;

use function basename;
use function extension_loaded;
use function yaml_parse_file;

class Yaml extends Config
{
    /**
     * Yaml constructor.
     *
     * @param string     $filePath
     * @param array|null $callbacks
     *
     * @throws Exception
     */
    public function __construct(string $filePath, array $callbacks = null)
    {
        $ndocs = 0;

        if (true !== extension_loaded("yaml")) {
            throw new Exception(
                "Yaml extension not loaded"
            );
        }

        if (empty($callbacks)) {
            $yamlConfig = yaml_parse_file($filePath);
        } else {
            $yamlConfig = yaml_parse_file(
                $filePath,
                0,
                $ndocs,
                $callbacks
            );
        }

        if (false === $yamlConfig) {
            throw new Exception(
                "Configuration file " .
                basename($filePath) .
                " cannot be loaded"
            );
        }

        parent::__construct($yamlConfig);
    }
}
