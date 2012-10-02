<?php

namespace DCMS\Bundle\RoutingBundle\Routing\Exception;
use DCMS\Bundle\RoutingBundle\Entity\Endpoint;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class EPClassNotFound extends ResourceNotFoundException
{
    public function __construct(Endpoint $endpoint)
    {
        $m = "Endpoint class '%s' for path '%s' (id: %d) not found.";
        $m = sprintf($m, $endpoint->getEPClass(), $endpoint->getPath(), $endpoint->getId());
        parent::__construct($m);
    }
}

