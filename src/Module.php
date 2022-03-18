<?php

namespace Jaxon\Yii;

use Yii;
use yii\web\Response;

use function rtrim;
use function header;
use function jaxon;

class Module extends \yii\base\Module
{
    use \Jaxon\App\AppTrait;

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
        $this->jaxon = jaxon();
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
        // Set the default view namespace
        $this->addViewNamespace('default', '', '', 'yii');
        // Add the view renderer
        $this->addViewRenderer('yii', function() {
            return new View();
        });
        // Set the session manager
        $this->setSessionManager(function() {
            return new Session();
        });
        // Set the framework service container wrapper
        $this->setAppContainer(new Container());
        // Set the logger
        $this->setLogger(new Logger());

        $bIsDebug = ((YII_ENV_DEV) ? true : false);
        $sAppPath = rtrim(Yii::getAlias('@app'), '/');
        $sJsUrl = rtrim(Yii::getAlias('@web'), '/') . '/jaxon/js';
        $sJsDir = rtrim(Yii::getAlias('@webroot'), '/') . '/jaxon/js';

        // Read the config options.
        $aOptions = $this->jaxon->readConfig($sAppPath . '/config/jaxon.php');
        $aLibOptions = $aOptions['lib'] ?? [];
        $aAppOptions = $aOptions['app'] ?? [];

        $this->bootstrap()
            ->lib($aLibOptions)
            ->app($aAppOptions)
            // ->uri($sUri)
            ->js(!$bIsDebug, $sJsUrl, $sJsDir, !$bIsDebug)
            ->setup();
    }

    /**
     * @inheritDoc
     */
    public function httpResponse(string $sCode = '200')
    {
        // Get the reponse to the request
        $jaxonResponse = $this->jaxon->getResponse();

        // Create and return a Yii HTTP response
        header('Content-Type: ' . $jaxonResponse->getContentType() .
            '; charset=' . $this->jaxon->getCharacterEncoding());
        Yii::$app->response->format = Response::FORMAT_JSON;
        Yii::$app->response->statusCode = $sCode;
        Yii::$app->response->content = $jaxonResponse->getOutput();
        return Yii::$app->response;
    }
}
