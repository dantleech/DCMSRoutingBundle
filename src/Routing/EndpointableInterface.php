<?php

namespace DCMS\Bundle\RoutingBundle\Routing;

interface EndpointableInterface
{
    /**
     * Implement to set endpoint path
     * 
     * This method will be called by Doctrine each
     * time the entity is loaded into memory.
     */
    public function setEndpointPath($epPath);

    /**
     * Return the endpoint path for the entity
     */
    public function getEndpointPath();
}
