<?php

namespace Jaxon\Yii\Controllers;

use yii\web\Controller;
use Yii;

class JaxonController extends Controller
{
    public function actionIndex()
    {
        // Process Jaxon request
        $jaxon = Yii::$app->getModule('jaxon');

        if($jaxon->canProcessRequest())
        {
            $jaxon->processRequest();
        }
    }
}
