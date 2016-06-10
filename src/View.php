<?php

namespace Jaxon\Yii;

class View
{
    protected static $data;
    protected $yii;

    public function __construct()
    {
        if(!is_array(self::$data))
        {
            self::$data = array();
        }
        $this->yii = \Yii::app()->controller;
    }

    /**
     * Make a piece of data available for all views
     *
     * @param string        $name            The data name
     * @param string        $value           The data value
     * 
     * @return void
     */
    public function share($name, $value)
    {
        self::$data[$name] = $value;
    }

    /**
     * Render a template
     *
     * @param string        $template        The template path
     * @param string        $data            The template data
     * 
     * @return mixed        The rendered template
     */
    public function render($template, array $data = array())
    {
        return $this->yii->render($template, array_merge(self::$data, $data), true);
    }
}
