<?php

namespace DCMS\Bundle\RoutingBundle\Routing;
use DCMS\Bundle\RoutingBundle\Routing\EndpointableInterface;
use DCMS\Bundle\RoutingBundle\Entity\Endpoint;
use DCMS\Bundle\RoutingBundle\Repository\EndpointRepository;

class EndpointManager
{
    protected $epClasses = array();
    protected $epRepo;

    public function __construct(EndpointRepository $epRepo)
    {
        $this->epRepo = $epRepo;
    }

    public function getEndpointForEntity($entity)
    {
        $epClass = $this->getEPCLassForEntity($entity);
        $endpoint = $this->epRepo->findOneBy(array(
            'epClass' => $epClass->getKey(),
            'foreignId' => $entity->getId(),
        ));

        if (!$endpoint) {
            $endpoint = new Endpoint;
            $endpoint->setEpClass($epClass->getKey());
            $endpoint->setForeignId($entity->getId()); 
        }

        return $endpoint;
    }

    public function getHandlerForEntity($entity)
    {
        foreach ($this->epClasss as $epClass) {
            if ($epClass->handles($entity)) {
                return $epClass;
            }
        }

        throw new Exception\EPClassNotFoundForEntity($entity);
    }

    public function registerHandler(EndpointHandler $epClass)
    {
        $this->epClasss[$epClass->getKey()] = $epClass;
    }

    protected function getDefaultsForPath(Endpoint $endpoint)
    {
        $defaults = array();
        $defaults['_route'] = 'dcms_endpoint_'.str_replace('/', '_', $endpoint->getPath());

        $epClassKey = $endpoint->getEPClass();

        if (!isset($this->epClasss[$epClassKey])) {
            throw new Exception\HandlerNotFound($endpoint);
        }

        $epClass = $this->epClasss[$epClassKey];
        $epClassDefaults = $epClass->getDefaults($endpoint);
        $defaults = array_merge($defaults, $epClassDefaults);

        return $defaults;
    }

    public function handleMatch(Site $site, $path)
    {
        $endpoint = $this->epRepo->getByPath($path);

        if ($endpoint) {
            $defaults = $this->getDefaultsForPath($endpoint);
            return $defaults;
        }

        return null;
    }
}

