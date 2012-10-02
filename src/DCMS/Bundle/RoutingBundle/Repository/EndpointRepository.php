<?php

namespace DCMS\Bundle\RoutingBundle\Repository;
use Doctrine\ORM\EntityRepository;

class EndpointRepository extends EntityRepository
{
    public function getByPath($path)
    {
        return $this->findOneBy(array(
            'path' => $path,
        ));
    }
}
