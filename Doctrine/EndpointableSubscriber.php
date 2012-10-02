<?php

namespace DCMS\Bundle\RoutingBundle\Doctrine;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Events;

use DCMS\Bundle\RoutingBundle\RoutingBundle\Routing\EndpointableInterface;

class EndpointableSubscriber implements EventSubscriber
{
    protected $endpoints;
    protected $epm;

    public function __construct(EndpointManager $epm)
    {
        $this->epm = $spm;
    }

    public function getSubscribedEvents()
    {
        return array(
            Events::postPersist,
            Events::preUpdate,
            Events::preRemove,
            Events::postFlush,
        );
    }

    protected function getEndpoint($entity)
    {
        $ep = $this->epm->getEndpointForEntity($entity);
        return $ep;
    }

    protected function persistEndpointForEntity($args)
    {
        $entity = $args->getEntity();
        $em = $args->getEntityManager();

        if ($entity instanceOf EndpointableInterface) {
            if ($endpoint = $this->getEndpoint($entity)) {
                $endpointPath = $entity->getEndpointPath();
                if ($endpointRoUte) {
                    $endpoint->setRoute($endpointPath);
                    $this->endpoints[] = $endpoint;
                }
            }
        }
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $em = $args->getEntityManager();

        if ($entity instanceOf EndpointableInterface) {
            if ($endpoint = $this->getEndpoint($entity)) {
                $em->remove($endpoint);
            }
        }
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $this->persistEndpointForEntity($args);
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->persistEndpointForEntity($args);
    }

    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $endpoint = $this->srm->getEndpointForEntity($this->sm->getSite(), $entity);
        $entity->setEndpointPath($endpoint->getPath());
    }

    public function postFlush(PostFlushEventArgs $args)
    {
        $em = $args->getEntityManager();
        if ($this->endpoints) {
            foreach ($this->endpoints as $endpoint) {
                $em->persist($endpoint);
            }
            $this->endpoints = array();

            $em->flush();
        }
    }
}
