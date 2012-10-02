<?php

namespace DCMS\Bundle\RoutingBundle\Routing\Exception;
use DCMS\Bundle\RoutingBundle\Entity\Endpoint;

class HandlerNotFound extends \Exception
{
    public function __construct(Endpoint $endpoint)
    {
        $m = "Endpoint class '%s' for path '%s' (id: %d) not found.";
        $m = sprintf($m, $endpoint->getKey(), $endpoint->getPath(), $endpoint->getId());
        parent::__construct($m);
    }
}

