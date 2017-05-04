<?php
/**
 * Created by PhpStorm.
 * User: Ricardo Fiorani
 * Date: 31/08/2015
 * Time: 21:07.
 */
namespace MichaelQuattrochi\Container\Factory;

use MichaelQuattrochi\Container\ServicesContainer;

class ServicesContainerFactory
{
    public function __invoke()
    {
        $configFile = require __DIR__.'/../../../config/config.php';
        $servicesContainer = new ServicesContainer($configFile);

        return $servicesContainer;
    }

    public static function createNewServiceMatcher()
    {
        $factory = new self();

        return $factory();
    }
}
