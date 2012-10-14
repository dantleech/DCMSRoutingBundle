<?php

namespace DCMS\Bundle\RoutingBundle\Repository;
use Doctrine\ODM\PHPCR\DocumentRepository;

class EndpointRepository extends DocumentRepository
{
    public function getByPath($path)
    {
        return $this->findOneBy(array(
            'path' => $path,
        ));
    }
}
