<?php

namespace Ylly\Extension\SiteRoutingBundle\Routing\Exception;
use Ylly\Extension\SiteRoutingBundle\Entity\SiteRoute;

class EPClassNotFoundForEntity extends \Exception
{
    public function __construct($entity)
    {
        $m = "Endpoint class (route handler) for entity '%s' not found.";
        $m = sprintf($m, get_class($entity));
        parent::__construct($m);
    }
}
