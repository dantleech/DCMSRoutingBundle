<?php

namespace DCMS\Bundle\RoutingBundle\Routing;
use Symfony\Component\DependencyInjection\ContainerInterface;
use DCMS\Bundle\RoutingBundle\Routing\EndpointableInterface;
use DCMS\Bundle\RoutingBundle\Entity\Endpoint;
use DCMS\Bundle\RoutingBundle\Repository\EndpointRepository;

class EndpointManager
{
    protected $epClasses = array();
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    protected function getEPRepo()
    {
        return $this->container->get('dcms_routing.repository.endpoint');
    }

    public function getEndpointForEntity($entity)
    {
        $epClass = $this->getEPClassForEntity($entity);
        $endpoint = $this->getEPRepo()->findOneBy(array(
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

    public function getEPClassForEntity($entity)
    {
        foreach ($this->epClasses as $epClass) {
            if ($epClass->handles($entity)) {
                return $epClass;
            }
        }

        throw new Exception\EPClassNotFoundForEntity($entity);
    }

    public function registerEPClass(EndpointClass $epClass)
    {
        $this->epClasses[$epClass->getKey()] = $epClass;
    }

    protected function getDefaultsForPath(Endpoint $endpoint)
    {
        $defaults = array();
        $defaults['_route'] = 'dcms_endpoint_'.str_replace('/', '_', $endpoint->getId());

        $epClassKey = $endpoint->getEPClass();

        if (!isset($this->epClasses[$epClassKey])) {
            throw new Exception\EPClassNotFound($endpoint);
        }

        $epClass = $this->epClasses[$epClassKey];
        $epClassDefaults = $epClass->getDefaults($endpoint);
        $defaults = array_merge($defaults, $epClassDefaults);

        return $defaults;
    }

    public function handleMatch($path)
    {
        $endpoint = $this->getEPRepo()->getByPath($path);

        if ($endpoint) {
            $defaults = $this->getDefaultsForPath($endpoint);
            return $defaults;
        }

        return null;
    }

    /**
     * Proxy method to cutdown on dependencies in
     * validator.
     */
    public function getEndpointByPath($path)
    {
        return $this->getEPRepo()->getByPath($path);
    }
}
