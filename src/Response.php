<?php

namespace Jaxon\Yii;

class Response extends \Jaxon\Response\Response
{
    /**
     * Create a new Response instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Wrap the Jaxon response in a Yii HTTP response.
     *
     * @param  string  $code
     *
     * @return string  the HTTP response
     */
    public function http($code = '200')
    {
        // Create and return a Yii HTTP response
        header('Content-Type: ' . $this->getContentType() . '; charset=' . $this->getCharacterEncoding());
        Yii::$app->response->statusCode = $core;
        Yii::$app->response->content = $this->getOutput();

        return Yii::$app->response;
    }
}
