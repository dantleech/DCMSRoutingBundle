<?php

namespace DCMS\Bundle\RoutingBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use DCMS\Bundle\RoutingBundle\Routing\Router;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use DCMS\Bundle\RoutingBundle\Routing\EndpointManager;

class RouterTest extends WebTestCase
{
    public function setUp()
    {
        // real objects
        $container = new ContainerBuilder;
        $this->epm = new EndpointManager($container);

        // mock objects
        $this->epRepo = $this->getMockBuilder('DCMS\Bundle\RoutingBundle\Repository\EndpointRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $this->ep = $this->getMock('DCMS\Bundle\RoutingBundle\Document\Endpoint');
        $this->epClass = $this->getMock('DCMS\Bundle\RoutingBundle\Routing\EndpointClass');
        $this->epClass->expects($this->any())
            ->method('getKey')
            ->will($this->returnValue('test'));

        $container->set('dcms_routing.repository.endpoint', $this->epRepo);
    }

    /**
     * @expectedException Symfony\Component\Routing\Exception\ResourceNotFoundException
     */
    public function testMatch_notFound()
    {
        $router = new Router($this->epm);
        $router->match('/notfound');
    }

    /**
     * @expectedException Symfony\Component\Routing\Exception\ResourceNotFoundException
     */
    public function testMatch_handlerNotFound()
    {
        $this->epRepo->expects($this->once())
            ->method('getByPath')
            ->with('/foobar')
            ->will($this->returnValue($this->ep));
        $this->ep->expects($this->any())
            ->method('getEPClass')
            ->will($this->returnValue('test'));

        $router = new Router($this->epm);
        $router->match('/foobar');
    }

    public function testMatch_found()
    {
        $this->epRepo->expects($this->once())
            ->method('getByPath')
            ->with('/foobar')
            ->will($this->returnValue($this->ep));
        $this->ep->expects($this->any())
            ->method('getEPClass')
            ->will($this->returnValue('test'));
        $this->ep->expects($this->once())
            ->method('getId')
            ->will($this->returnValue(5));
        $this->epClass->expects($this->once())
            ->method('getDefaults')
            ->will($this->returnValue(array(
                'foo' => 'bar'
            )));
        $this->epm->registerEPClass($this->epClass);

        $router = new Router($this->epm);
        $defs = $router->match('/foobar');
        $this->assertEquals(array(
            '_route' => 'dcms_endpoint_5',
            'foo' => 'bar',
        ), $defs);
    }
}
