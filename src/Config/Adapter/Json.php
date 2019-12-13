<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Config\Adapter;

use Cardoe\Config\Config;

class Json extends Config
{
    /**
     * Json constructor.
     *
     * @param string $filePath
     */
    public function __construct(string $filePath)
    {
        parent::__construct(
            json_decode(
                file_get_contents($filePath),
                true
            )
        );
    }
}
