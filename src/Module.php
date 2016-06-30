<?php

namespace Jaxon\Yii;

class Module extends \yii\base\Module
{
    use \Jaxon\Framework\JaxonTrait;

    /**
     * Create a new Jaxon instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Initialise the properties inherited from JaxonTrait.
        $this->jaxon = \Jaxon\Jaxon::getInstance();
        $this->validator = \Jaxon\Utils\Container::getInstance()->getValidator();
        $this->response = new \Jaxon\Yii\Response();
        $this->view = new \Jaxon\Yii\View();
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
        $this->setup();
    }

    /**
     * Initialise the Jaxon module.
     *
     * @return void
     */
    public function setup()
    {
        // This function should be called only once
        if(($this->setupCalled))
        {
            return;
        }
        $this->setupCalled = true;

        // initialize the module with the configuration loaded from config.php
        // \Yii::configure($this, require(__DIR__ . '/config.php'));

        $isDebug = ((YII_ENV_DEV) ? true : false);
        $appPath = rtrim(\Yii::getAlias('@app'), '/') . '/';
        $baseUrl = rtrim(\Yii::getAlias('@web'), '/') . '/';
        $baseDir = rtrim(\Yii::getAlias('@webroot'), '/') . '/';
        $config = require($appPath . 'config/jaxon.php');
        $appConfig = array_key_exists('app', $config) ? $config['app'] : array();
        $libConfig = array_key_exists('lib', $config) ? $config['lib'] : array();

        // Jaxon application settings
        $controllerDir = (array_key_exists('dir', $appConfig) ? $appConfig['dir'] : $appPath . 'jaxon');
        $namespace = (array_key_exists('namespace', $appConfig) ? $appConfig['namespace'] : '\\Jaxon\\App');

        $excluded = (array_key_exists('excluded', $appConfig) ? $appConfig['excluded'] : array());
        // The public methods of the Controller base class must not be exported to javascript
        $controllerClass = new \ReflectionClass('\\Jaxon\\Yii\\Controller');
        foreach ($controllerClass->getMethods(\ReflectionMethod::IS_PUBLIC) as $xMethod)
        {
            $excluded[] = $xMethod->getShortName();
        }
        // Use the Composer autoloader
        $this->jaxon->useComposerAutoloader();
        // Jaxon library default options
        $this->jaxon->setOptions(array(
            'js.app.extern' => !$isDebug,
            'js.app.minify' => !$isDebug,
            'js.app.uri' => $baseUrl . 'jaxon/js',
            'js.app.dir' => $baseDir . 'jaxon/js',
        ));
        // Jaxon library settings
        \Jaxon\Config\Config::setOptions($libConfig);
        // Set the request URI
        if(!$this->jaxon->getOption('core.request.uri'))
        {
            $this->jaxon->setOption('core.request.uri', 'jaxon');
        }
        // Register the default Jaxon class directory
        $this->jaxon->addClassDir($controllerDir, $namespace, $excluded);
    }
}
