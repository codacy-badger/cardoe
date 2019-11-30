<?php

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cardoe\Http\Client\Middleware;

use Cardoe\Http\Client\Request\HandlerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class UserAgent
 *
 * @package Cardoe\Http\Client\Middleware
 *
 * @property string $agent
 */
class UserAgent implements MiddlewareInterface
{
    /**
     * @var string
     */
    private $agent;

    /**
     * @param string $agent
     */
    public function __construct(string $agent = null)
    {
        $this->agent = $agent ?: sprintf("Cardoe HTTP Client PHP/%s", PHP_VERSION);
    }

    /**
     * @inheritdoc
     */
    public function process(
        RequestInterface $request,
        HandlerInterface $handler
    ): ResponseInterface {
        if (!$request->hasHeader("User-Agent")) {
            $request = $request->withHeader("User-Agent", $this->agent);
        }

        return $handler->handle($request);
    }
}
