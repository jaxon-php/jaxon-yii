<?php

return array(
    'app' => array(
        'controllers' => array(
            array(
                'directory' => rtrim(\Yii::getAlias('@app'), '/') . '/jaxon/controllers',
                'namespace' => '\\Jaxon\\App',
                // 'separator' => '', // '.' or '_'
                // 'protected' => array(),
            ),
        ),
    ),
    'lib' => array(
        'core' => array(
            'language' => 'en',
            'encoding' => 'UTF-8',
            'request' => array(
                'uri' => 'jaxon',
            ),
            'prefix' => array(
                'class' => '',
            ),
            'debug' => array(
                'on' => false,
                'verbose' => false,
            ),
            'error' => array(
                'handle' => false,
            ),
        ),
        'js' => array(
            'lib' => array(
                // 'uri' => '',
            ),
            'app' => array(
                // 'uri' => '',
                // 'dir' => '',
                // 'extern' => true,
                // 'minify' => true,
                'options' => '',
            ),
        ),
    ),
);
