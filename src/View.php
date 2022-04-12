<?php

namespace Jaxon\Yii;

use Jaxon\App\View\Store;
use Jaxon\App\View\ViewInterface;

use Yii;

use function trim;

class View implements ViewInterface
{
    /**
     * @var mixed The Yii controller
     */
    protected $xController;

    /**
     * The constructor
     */
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
    public function addNamespace(string $sNamespace, string $sDirectory, string $sExtension = '')
    {}

    /**
     * Render a view
     *
     * @param Store         $store        A store populated with the view data
     *
     * @return string
     */
    public function render(Store $store): string
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
