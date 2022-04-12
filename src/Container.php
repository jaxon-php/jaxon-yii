<?php

/**
 * Container.php - Dependency injection gateway
 *
 * @package jaxon-core
 * @author Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @copyright 2016 Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @license https://opensource.org/licenses/BSD-3-Clause BSD 3-Clause License
 * @link https://github.com/jaxon-php/jaxon-core
 */

namespace Jaxon\Yii;

use Psr\Container\ContainerInterface;
use Yii;

class Container implements ContainerInterface
{
    /**
     * Check if a given class is defined in the container
     *
     * @param string $id             A full class name
     *
     * @return bool
     */
    public function has(string $id)
    {
        return Yii::$container->has($id);
    }

    /**
     * Get a class instance
     *
     * @param string $id             A full class name
     *
     * @return mixed                The class instance
     */
    public function get(string $id)
    {
        return Yii::$container->get($id);
    }
}
