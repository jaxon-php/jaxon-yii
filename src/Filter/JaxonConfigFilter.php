<?php

/**
 * JaxonConfigFilter.php
 *
 * Yii filter to load Jaxon config.
 *
 * @package jaxon-core
 * @author Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @copyright 2022 Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @license https://opensource.org/licenses/BSD-3-Clause BSD 3-Clause License
 * @link https://github.com/jaxon-php/jaxon-core
 */

namespace Jaxon\Yii\Filter;

use Jaxon\App\AppInterface;
use Jaxon\Exception\SetupException;
use Jaxon\Yii\Jaxon;
use yii\base\ActionFilter;
use Yii;

use function jaxon;
use function rtrim;

class JaxonConfigFilter extends ActionFilter
{
    /**
     * @inheritDoc
     * @throws SetupException
     */
    public function beforeAction($action)
    {
        jaxon()->di()->set(AppInterface::class, function() {
            return new Jaxon();
        });
        // Load the config
        jaxon()->app()->setup(rtrim(Yii::getAlias('@app'), '/') . '/config/jaxon.php');

        return parent::beforeAction($action);
    }
}
