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
            ->run();

        // Prevent the Jaxon library from sending the response or exiting
        $jaxon->setOption('core.response.send', false);
        $jaxon->setOption('core.process.exit', false);
    }

    /**
     * Process an incoming Jaxon request, and return the response.
     *
     * @return mixed
     */
    public function processRequest()
    {
        $jaxon = jaxon();
        // Process the jaxon request
        $jaxon->processRequest();
        // Get the reponse to the request
        $jaxonResponse = $jaxon->di()->getResponseManager()->getResponse();

        // Create and return a Yii HTTP response
        $code = '200';
        header('Content-Type: ' . $jaxonResponse->getContentType() .
            '; charset=' . $jaxonResponse->getCharacterEncoding());
        \Yii::$app->response->statusCode = $code;
        \Yii::$app->response->content = $jaxonResponse->getOutput();
        return \Yii::$app->response;
    }
}
