<?php

namespace DCMS\Bundle\RoutingBundle\Routing;
use DCMS\Bundle\RoutingBundle\Entity\Endpoint;

/**
 * Test / Example endpoint class implementation
 */
class TestEndpointClass extends EndpointClass
{
    public function getKey()
    {
        return 'test';
    }

    public function getDefaults(Endpoint $ep)
    {
        return array();
    }

    public function handles($entity)
    {
        if (get_class($entity) == 'DCMS\Bundle\RoutingBundle\Entity\TestEndpoint') {
            return true;
        }

        return false;
    }
}
