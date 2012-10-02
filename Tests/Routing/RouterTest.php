<?php

namespace DCMS\Bundle\RoutingBundle\Test\Routing;
use DCMS\Bundle\RoutingBundle\Routing\Router;

class RouterTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->route = $this->getMock('DCMS\Bundle\RoutingBundle\Entity\Endpoint');
        $this->route->expects($this->once())
            ->method('getEpClass')
            ->will($this->returnValue('test'));

        $this->epRepo = $this->getMockBuilder('DCMS\Bundle\RoutingBundle\Repository\EndpointRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $this->epClass = $this->getMockBuilder('\DCMS\Bundle\RoutingBundle\Routing\EndpointClass')
            ->disableOriginalConstructor()
            ->getMock();
        $this->epClass->expects($this->once())
            ->method('getKey')
            ->will($this->returnValue('test'));

        $this->router = new Router($this->epRepo);
        $this->router->addEndpointClass($this->epClass);
    }

    public function testMatch()
    {
        $this->epRepo->expects($this->once())
            ->method('getByRoute')
            ->with('/foobar')
            ->will($this->returnValue($this->route));
        $this->epClass->expects($this->once())
            ->method('getDefaults')
            ->with($this->route)
            ->will($this->returnValue(array(
                'foo' => 'bar',
            )));

        $defs = $this->router->match('/foobar');

        $this->assertEquals(array(
            'foo' => 'bar',
        ), $defs);
    }
}
