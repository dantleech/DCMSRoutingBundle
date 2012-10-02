<?php

namespace DCMS\Bundle\RoutingBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use DCMS\Bundle\RoutingBundle\Routing\Router;

class RouterTest extends WebTestCase
{
    public function setUp()
    {
        $this->client = static::createClient();
        $this->container = $this->client->getContainer();

        // real objects
        $this->epm = $this->container->get('dcms_routing.endpoint_manager');

        // mock objects
        $this->epRepo = $this->getMockBuilder('DCMS\Bundle\RoutingBundle\Repository\EndpointRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $this->ep = $this->getMock('DCMS\Bundle\RoutingBundle\Entity\Endpoint');
        $this->epClass = $this->getMock('DCMS\Bundle\RoutingBundle\Routing\EndpointClass');
        $this->epClass->expects($this->any())
            ->method('getKey')
            ->will($this->returnValue('test'));

        $this->container->set('dcms_routing.repository.endpoint', $this->epRepo);
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
        $epm = $this->container->get('dcms_routing.endpoint_manager');
        $this->epRepo->expects($this->once())
            ->method('getByPath')
            ->with('/foobar')
            ->will($this->returnValue($this->ep));
        $this->ep->expects($this->any())
            ->method('getEPClass')
            ->will($this->returnValue('test'));

        $router = new Router($epm);
        $router->match('/foobar');
    }

    public function testMatch_found()
    {
        $epm = $this->container->get('dcms_routing.endpoint_manager');
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

        $router = new Router($epm);
        $defs = $router->match('/foobar');
        $this->assertEquals(array(
            '_route' => 'dcms_endpoint_5',
            'foo' => 'bar',
        ), $defs);
    }
}
