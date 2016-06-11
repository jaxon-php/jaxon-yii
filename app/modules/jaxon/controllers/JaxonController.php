<?php

namespace app\modules\jaxon\controllers;

use yii\web\Controller;

class JaxonController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function actionIndex()
    {
        // Set the layout
        $this->layout = 'site';

        return $this->render('index');
    }

    public function actionProcess()
    {
        // Process Jaxon request
        $jaxon = Yii::$app->getModule('jaxon');

        if($jaxon->canProcessRequest())
        {
            $jaxon->processRequest();
        }
    }
}
