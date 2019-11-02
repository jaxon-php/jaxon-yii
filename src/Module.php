<?php

namespace Jaxon\Yii;

class Module extends \yii\base\Module
{
    use \Jaxon\Features\App;

    /**
     * Default route for this package
     *
     * @var string
     */
    public $defaultRoute = 'jaxon';

    /**
     * Namespace of the controllers in this package
     *
     * @var string
     */
    public $controllerNamespace = 'Jaxon\\Yii\\Controllers';

    /**
     * Create a new Jaxon instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Call the parent contructor after member initialisation
        parent::__construct('jaxon');
    }

    /**
     * Initialise the Jaxon module.
     *
     * @return void
     */
    public function init()
    {
        $bIsDebug = ((YII_ENV_DEV) ? true : false);
        $sAppPath = rtrim(\Yii::getAlias('@app'), '/');
        $sJsUrl = rtrim(\Yii::getAlias('@web'), '/') . '/jaxon/js';
        $sJsDir = rtrim(\Yii::getAlias('@webroot'), '/') . '/jaxon/js';

        $jaxon = jaxon();
        $di = $jaxon->di();

        // Read the config options.
        $aOptions = $jaxon->config()->read($sAppPath . '/config/jaxon.php');
        $aLibOptions = key_exists('lib', $aOptions) ? $aOptions['lib'] : [];
        $aAppOptions = key_exists('app', $aOptions) ? $aOptions['app'] : [];

        $viewManager = $di->getViewmanager();
        // Set the default view namespace
        $viewManager->addNamespace('default', '', '', 'yii');
        // Add the view renderer
        $viewManager->addRenderer('yii', function () {
            return new View();
        });

        // Set the session manager
        $di->setSessionManager(function () {
            return new Session();
        });

        $this->bootstrap()
            ->lib($aLibOptions)
            ->app($aAppOptions)
            // ->uri($sUri)
            ->js(!$bIsDebug, $sJsUrl, $sJsDir, !$bIsDebug)
            ->run(false);
    }

    /**
     * Wrap the Jaxon response into an HTTP response.
     *
     * @param  $code        The HTTP Response code
     *
     * @return HTTP Response
     */
    public function httpResponse($code = '200')
    {
        // Create and return a Yii HTTP response
        header('Content-Type: ' . $this->ajaxResponse()->getContentType() .
            '; charset=' . $this->ajaxResponse()->getCharacterEncoding());
        \Yii::$app->response->statusCode = $code;
        \Yii::$app->response->content = $this->ajaxResponse()->getOutput();
        return \Yii::$app->response;
    }
}
