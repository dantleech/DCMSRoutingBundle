<?php

namespace DCMS\Bundle\RoutingBundle\Routing;
use DCMS\Bundle\RoutingBundle\Entity\Endpoint;

abstract class EndpointClass
{
    /**
     * Return a unique identifier for this endpoint class,
     * e.g. "dtl.markdown"
     */
    abstract public function getKey();

    /**
     * Return the default request parameters,
     * e.g.
     *
     * array(
     *   '_controller' => 'FoobarBundle:Bar:foo',
     *   'article_id' => $ep->getParameter('article_id'),
     * )
     */
    abstract public function getDefaults(Endpoint $ep);

    /**
     * Return TRUE if this class handles the given entity
     *
     * e.g. return get_class($ep) == 'foo';
     */
    abstract public function handles($entity);
}
