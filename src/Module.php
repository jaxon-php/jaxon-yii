<?php

namespace Jaxon\Yii;

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
    protected function setup()
    {
        $isDebug = ((YII_ENV_DEV) ? true : false);
        $appPath = rtrim(\Yii::getAlias('@app'), '/') . '/';
        $baseUrl = rtrim(\Yii::getAlias('@web'), '/') . '/';
        $baseDir = rtrim(\Yii::getAlias('@webroot'), '/') . '/';

        // Read and set the config options from the config file
        $jaxon = jaxon();
        $this->appConfig = $jaxon->readConfigFile($appPath . 'config/jaxon.php', 'lib', 'app');

        // Jaxon library settings
        // Default values
        if(!$jaxon->hasOption('js.app.extern'))
        {
            $jaxon->setOption('js.app.extern', !$isDebug);
        }
        if(!$jaxon->hasOption('js.app.minify'))
        {
            $jaxon->setOption('js.app.minify', !$isDebug);
        }
        if(!$jaxon->hasOption('js.app.uri'))
        {
            $jaxon->setOption('js.app.uri', $baseUrl . 'jaxon/js');
        }
        if(!$jaxon->hasOption('js.app.dir'))
        {
            $jaxon->setOption('js.app.dir', $baseDir . 'jaxon/js');
        }

        // Jaxon application settings
        // Default values
        if(!$this->appConfig->hasOption('controllers.directory'))
        {
            $this->appConfig->setOption('controllers.directory', $appPath . 'jaxon/Controllers');
        }
        if(!$this->appConfig->hasOption('controllers.namespace'))
        {
            $this->appConfig->setOption('controllers.namespace', '\\Jaxon\\App');
        }
        if(!$this->appConfig->hasOption('controllers.protected') || !is_array($this->appConfig->getOption('protected')))
        {
            $this->appConfig->setOption('controllers.protected', array());
        }
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
    protected function check()
    {
        // Todo: check the mandatory options
    }

    /**
     * Return the view renderer.
     *
     * @return void
     */
    protected function view()
    {
        if($this->viewRenderer == null)
        {
            $this->viewRenderer = new View();
        }
        return $this->viewRenderer;
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
