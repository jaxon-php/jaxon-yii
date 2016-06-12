<?php

namespace app\modules\jaxon\controllers;

use yii\web\Controller;

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
