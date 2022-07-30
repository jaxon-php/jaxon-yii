<?php

/**
 * JaxonAjaxMiddleware.php
 *
 * Middleware to process Jaxon ajax request.
 *
 * @package jaxon-core
 * @author Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @copyright 2022 Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @license https://opensource.org/licenses/BSD-3-Clause BSD 3-Clause License
 * @link https://github.com/jaxon-php/jaxon-core
 */

namespace Jaxon\Yii\Middleware;

use Jaxon\Request\Handler\Psr\PsrAjaxMiddleware;

use function Jaxon\jaxon;

class JaxonAjaxMiddleware extends PsrAjaxMiddleware
{
    /**
     * The constructor
     */
    public function __construct()
    {
        $di = jaxon()->di();
        parent::__construct($di, $di->getRequestHandler(), $di->getResponseManager());
    }
}
