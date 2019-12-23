<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Http\JWT\Token;

/**
 * Class AbstractItem
 *
 * @property array $data
 */
abstract class AbstractItem
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * @return string
     */
    public function getEncoded(): string
    {
        return $this->data["encoded"];
    }
}