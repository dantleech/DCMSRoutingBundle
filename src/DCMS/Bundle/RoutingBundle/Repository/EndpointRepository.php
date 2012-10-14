<?php

namespace DCMS\Bundle\RoutingBundle\Repository;
use Doctrine\ODM\PHPCR\DocumentRepository;

class EndpointRepository extends DocumentRepository
{
    public function getByPath($path)
    {
        $ep = $this->findOneBy(array(
            'path' => $path,
        ));
        var_dump($ep);
        return $ep;
    }
}
