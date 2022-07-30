<?php

/**
 * JaxonConfigMiddleware.php
 *
 * Middleware to load Jaxon config.
 *
 * @package jaxon-core
 * @author Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @copyright 2022 Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @license https://opensource.org/licenses/BSD-3-Clause BSD 3-Clause License
 * @link https://github.com/jaxon-php/jaxon-core
 */

namespace Jaxon\Yii\Middleware;

use Jaxon\App\AppInterface;
use Jaxon\Exception\SetupException;
use Jaxon\Yii\Jaxon;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Yii;

use function Jaxon\jaxon;
use function rtrim;

class JaxonConfigMiddleware implements MiddlewareInterface
{
    /**
     * @inheritDoc
     * @throws SetupException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        jaxon()->di()->set(AppInterface::class, function() {
            return new Jaxon();
        });
        // Load the config
        jaxon()->app()->setup(rtrim(Yii::getAlias('@app'), '/') . '/config/jaxon.php');

        return $handler->handle($request);
    }
}
