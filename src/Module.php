<?php

namespace Jaxon\Yii;

use Jaxon\Config\Php as Config;

class Module extends \yii\base\Module
{
    use \Jaxon\Module\Traits\Module;

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
    }

    /**
     * Set the module specific options for the Jaxon library.
     *
     * @return void
     */
    protected function jaxonSetup()
    {
        $isDebug = ((YII_ENV_DEV) ? true : false);
        $appPath = rtrim(\Yii::getAlias('@app'), '/');
        $baseUrl = rtrim(\Yii::getAlias('@web'), '/');
        $baseDir = rtrim(\Yii::getAlias('@webroot'), '/');

        // Read and set the config options from the config file
        $this->appConfig = Config::read($appPath . '/config/jaxon.php', 'lib', 'app');

        // Jaxon library default settings
        $this->setLibraryOptions(!$isDebug, !$isDebug, $baseUrl . '/jaxon/js', $baseDir . '/jaxon/js');

        // Jaxon application default settings
        $this->setApplicationOptions($appPath . '/jaxon/controllers', '\\Jaxon\\App');

        // Jaxon controller class
        $this->setControllerClass('\\Jaxon\\Yii\\Controller');
    }

    /**
     * Set the module specific options for the Jaxon library.
     *
     * This method needs to set at least the Jaxon request URI.
     *
     * @return void
     */
    protected function jaxonCheck()
    {
        // Todo: check the mandatory options
    }

    /**
     * Return the view renderer.
     *
     * @return void
     */
    protected function jaxonView()
    {
        if($this->jaxonViewRenderer == null)
        {
            $this->jaxonViewRenderer = new View();
        }
        return $this->jaxonViewRenderer;
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
        header('Content-Type: ' . $this->response->getContentType() . '; charset=' . $this->response->getCharacterEncoding());
        \Yii::$app->response->statusCode = $code;
        \Yii::$app->response->content = $this->response->getOutput();
        return \Yii::$app->response;
    }
}
