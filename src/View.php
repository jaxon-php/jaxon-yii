<?php

namespace Jaxon\Yii;

use Jaxon\Utils\View\Store;
use Jaxon\Contracts\View as ViewContract;

use Yii;

use function trim;

class View implements ViewContract
{
    protected $xController;

    public function __construct()
    {
        $this->xController = Yii::$app->controller;
    }

    /**
     * Add a namespace to this view renderer
     *
     * @param string        $sNamespace         The namespace name
     * @param string        $sDirectory         The namespace directory
     * @param string        $sExtension         The extension to append to template names
     *
     * @return void
     */
    public function addNamespace($sNamespace, $sDirectory, $sExtension = '')
    {}

    /**
     * Render a view
     *
     * @param Store         $store        A store populated with the view data
     *
     * @return string        The string representation of the view
     */
    public function render(Store $store)
    {
        // Render the template
        $sViewPath = $store->getViewName();
        $firstChar = $sViewPath{0};
        if($firstChar != '/' && $firstChar != '@')
        {
            $sViewPath = '//' . $sViewPath;
        }
        return trim($this->xController->renderPartial($sViewPath, $store->getViewData(), true), " \t\n");
    }
}
