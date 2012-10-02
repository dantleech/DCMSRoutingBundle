<?php

namespace DCMS\Bundle\RoutingBundle\Routing\Exception;
use Ylly\Extension\SiteRoutingBundle\Entity\SiteRoute;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class EPClassNotFoundForEntity extends ResourceNotFoundException
{
    public function __construct($entity)
    {
        $m = "Endpoint class for entity '%s' not found.";
        $m = sprintf($m, get_class($entity));
        parent::__construct($m);
    }
}
