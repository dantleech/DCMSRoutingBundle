<?php

namespace DCMS\Bundle\RoutingBundle\Routing;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;
use DCMS\Bundle\RoutingBundle\Routing\EndpointManager;

class Router implements RouterInterface
{
    protected $epm;
    protected $epClasses = array();

    public function __construct(EndpointManager $epm)
    {
        $this->epm = $epm;
    }

    public function addEndpointClass(EndpointClass $epClass)
    {
        $this->epClasses[$epClass->getKey()] = $epClass;
    }

    /**
     * Tries to match a URL path with a set of routes.
     *
     * If the matcher can not find information, it must throw one of the exceptions documented
     * below.
     *
     * @param string $pathinfo The path info to be parsed (raw format, i.e. not pathinfodecoded)
     *
     * @return array An array of parameters
     *
     * @throws ResourceNotFoundException If the resource could not be found
     * @throws MethodNotAllowedException If the resource was found but the request method is not allowed
     *
     * @api
     */
    public function match($pathinfo)
    {
        if (substr($pathinfo, 0, 11) == '/_internal/') {
            throw new ResourceNotFoundException("/_internal/ route, passing back to chain router.");
        }

        $defaults = $this->epm->handleMatch($pathinfo);

        if ($defaults) {
            return $defaults;
        }

        throw new ResourceNotFoundException('Cannot find a matching route');
    }

    /**
     * Generates a URL from the given parameters.
     *
     * If the generator is not able to generate the url, it must throw the RouteNotFoundException
     * as documented below.
     *
     * @param string  $name       The name of the route
     * @param mixed   $parameters An array of parameters
     * @param Boolean $absolute   Whether to generate an absolute URL
     *
     * @return string The generated URL
     *
     * @throws RouteNotFoundException if route doesn't exist
     *
     * @api
     */
    public function generate($name, $parameters = array(), $absolute = false)
    {
        throw new ResourceNotFoundException('Generate method not supported');
    }

    public function getRouteCollection()
    {
    }

    /**
     * Sets the request context.
     *
     * @param RequestContext $context The context
     *
     * @api
     */
    public function setContext(RequestContext $context)
    {
    }

    /**
     * Gets the request context.
     *
     * @return RequestContext The context
     *
     * @api
     */
    public function getContext()
    {
    }
}
