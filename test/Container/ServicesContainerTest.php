<?php
/**
 * Created by PhpStorm.
 * User: Ricardo Fiorani
 * Date: 10/02/2016
 * Time: 19:58
 */

namespace Coalmarch\Test\Container;


use PHPUnit_Framework_TestCase;
use Coalmarch\Container\ServicesContainer;
use stdClass;

class ServicesContainerTest extends PHPUnit_Framework_TestCase
{
    public function testServiceContainerServiceRegistrationByArray()
    {
        $config = $this->getMockConfig();
        $serviceContainer = $this->createServiceContainer($config);
        $this->assertTrue($serviceContainer->hasService('Youtube'));
        $this->assertInstanceOf('\\Coalmarch\\Renderer\\DefaultRenderer', $serviceContainer->getRenderer());
    }

    public function testServiceContainerServiceRegistrationByInjection()
    {
        $serviceContainer = $this->createServiceContainer();
        $serviceContainer->registerService('TestService', array('#testPattern#'), function () {
            // @todo test the injected service maybe ?
        });

        $this->assertContains('TestService', $serviceContainer->getServiceNameList());
        $this->setExpectedException('\\Coalmarch\\Exception\\DuplicatedServiceNameException');
        $serviceContainer->registerService('TestService', array('#testPattern#'), function () {
        });
    }

    public function testServicesList()
    {
        $config = $this->getMockConfig();
        $serviceContainer = $this->createServiceContainer($config);
        $this->assertInternalType('array', $serviceContainer->getServices());
        $this->assertContains('Youtube', $serviceContainer->getServices());
    }

    public function testIfReturnsAlreadyInstantiatedFactory(){
        $config = $this->getMockConfig();
        $serviceContainer = $this->createServiceContainer($config);
        $factory = $serviceContainer->getFactory('Youtube');
        $this->assertInstanceOf('\\Coalmarch\\Adapter\\Youtube\\Factory\\YoutubeServiceAdapterFactory',$factory);

        $alreadyInstantiatedFactory = $serviceContainer->getFactory('Youtube');
        $this->assertEquals($factory,$alreadyInstantiatedFactory);
    }

    /**
     * @return ServicesContainer
     */
    private function createServiceContainer(array $constructArray = array())
    {
        $serviceContainer = new ServicesContainer($constructArray);

        return $serviceContainer;
    }

    /**
     * @return array
     */
    private function getMockConfig()
    {
        return array(
            'services' => array(
                'Youtube' => array(
                    'patterns' => array(
                        '#(?:<\>]+href=\")?(?:http://)?((?:[a-zA-Z]{1,4}\.)?youtube.com/(?:watch)?\?v=(.{11}?))[^"]*(?:\"[^\<\>]*>)?([^\<\>]*)(?:)?#',
                        '%(?:youtube\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i',
                    ),
                    'factory' => '\\Coalmarch\\Adapter\\Youtube\\Factory\\YoutubeServiceAdapterFactory',
                ),
            ),
            'renderer' => array(
                'name' => 'DefaultRenderer',
                'factory' => '\\Coalmarch\\Renderer\\Factory\\DefaultRendererFactory',
            )
        );
    }
}
