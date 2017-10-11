<?php

namespace Jaxon\Yii\Controllers;

use yii\web\Controller;
use Yii;

class JaxonController extends Controller
{
    /**
     * Callback for initializing a Jaxon class instance.
     *
     * This function is called anytime a Jaxon class is instanciated.
     *
     * @param object            $instance               The Jaxon class instance
     *
     * @return void
     */
    public function initInstance($instance)
    {
    }

    /**
     * Callback before processing a Jaxon request.
     *
     * @param object            $instance               The Jaxon class instance to call
     * @param string            $method                 The Jaxon class method to call
     * @param boolean           $bEndRequest            Whether to end the request or not
     *
     * @return void
     */
    public function beforeRequest($instance, $method, &$bEndRequest)
    {
    }

    /**
     * Callback after processing a Jaxon request.
     *
     * @param object            $instance               The Jaxon class instance called
     * @param string            $method                 The Jaxon class method called
     *
     * @return void
     */
    public function afterRequest($instance, $method)
    {
    }

    /**
     * Process a Jaxon request.
     *
     * The HTTP response is automatically sent back to the browser
     *
     * @return void
     */
    public function actionIndex()
    {
        // Process Jaxon request
        $jaxon = Yii::$app->getModule('jaxon');

        $jaxon->onInit(function ($instance) {
            $this->initInstance($instance);
        });
        $jaxon->onBefore(function ($instance, $method, &$bEndRequest) {
            $this->beforeRequest($instance, $method, $bEndRequest);
        });
        $jaxon->onAfter(function ($instance, $method) {
            $this->afterRequest($instance, $method);
        });

        if($jaxon->canProcessRequest())
        {
            $jaxon->processRequest();
        }
    }
}
