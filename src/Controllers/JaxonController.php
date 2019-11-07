<?php

namespace Jaxon\Yii\Controllers;

use yii\web\Controller;
use Yii;

class JaxonController extends Controller
{
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

        $jaxon->callback()->before(function ($target, &$bEndRequest) use ($jaxon) {
            /*
            if($target->isFunction())
            {
                $function = $target->getFunctionName();
            }
            elseif($target->isClass())
            {
                $class = $target->getClassName();
                $method = $target->getMethodName();
                // $instance = $jaxon->instance($class);
            }
            */
        });
        $jaxon->callback()->after(function ($target, $bEndRequest) {
            /*
            if($target->isFunction())
            {
                $function = $target->getFunctionName();
            }
            elseif($target->isClass())
            {
                $class = $target->getClassName();
                $method = $target->getMethodName();
            }
            */
        });

        if($jaxon->canProcessRequest())
        {
            $jaxon->processRequest();
            return $jaxon->httpResponse();
        }
    }
}
