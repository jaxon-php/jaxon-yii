<?php

namespace Jaxon\Yii;

use Jaxon\Module\View\Store;
use Jaxon\Module\View\Facade;

class View extends Facade
{
    protected $controller;

    public function __construct()
    {
        parent::__construct();
        $this->controller = \Yii::$app->controller;
    }

    /**
     * Render a view
     * 
     * @param Store         $store        A store populated with the view data
     * 
     * @return string        The string representation of the view
     */
    public function make(Store $store)
    {
        // Render the template
        $sViewPath = $store->getViewPath();
        $firstChar = $sViewPath{0};
        if($firstChar != '/' && $firstChar != '@')
        {
            $sViewPath = '//' . $sViewPath;
        }
        return trim($this->controller->renderPartial($sViewPath, $store->getViewData(), true), " \t\n");
    }
}
