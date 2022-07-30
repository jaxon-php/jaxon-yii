<?php

/**
 * Jaxon.php
 *
 * Jaxon app for Yii
 *
 * @package jaxon-core
 * @author Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @copyright 2022 Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @license https://opensource.org/licenses/BSD-3-Clause BSD 3-Clause License
 * @link https://github.com/jaxon-php/jaxon-core
 */

namespace Jaxon\Yii;

use Jaxon\App\AppInterface;
use Jaxon\App\Traits\AppTrait;
use Jaxon\Exception\SetupException;
use yii\web\Response;
use Yii;

use function header;
use function Jaxon\jaxon;
use function rtrim;

class Jaxon implements AppInterface
{
    use AppTrait;

    /**
     * The class constructor
     */
    public function __construct()
    {
        $this->initApp(jaxon()->di());
    }

    /**
     * @inheritDoc
     * @throws SetupException
     */
    public function setup(string $sConfigFile)
    {
        // Add the view renderer
        $this->addViewRenderer('yii', '', function() {
            return new View();
        });
        // Set the session manager
        $this->setSessionManager(function() {
            return new Session();
        });
        // Set the framework service container wrapper
        $this->setContainer(new Container());
        // Set the logger
        $this->setLogger(new Logger());

        $bExport = $bMinify = (YII_DEBUG ? false : true);
        $sJsUrl = rtrim(Yii::getAlias('@web'), '/') . '/jaxon/js';
        $sJsDir = rtrim(Yii::getAlias('@webroot'), '/') . '/jaxon/js';

        // Read the config options.
        $aOptions = $this->config()->read($sConfigFile);
        $aLibOptions = $aOptions['lib'] ?? [];
        $aAppOptions = $aOptions['app'] ?? [];

        $this->bootstrap()
            ->lib($aLibOptions)
            ->app($aAppOptions)
            ->asset($bExport, $bMinify, $sJsUrl, $sJsDir)
            ->setup();
    }

    /**
     * @inheritDoc
     */
    public function httpResponse(string $sCode = '200')
    {
        // Create and return a Yii HTTP response
        header('Content-Type: ' . $this->getContentType());
        Yii::$app->response->format = Response::FORMAT_JSON;
        Yii::$app->response->content = $this->ajaxResponse()->getOutput();

        return Yii::$app->response;
    }
}
