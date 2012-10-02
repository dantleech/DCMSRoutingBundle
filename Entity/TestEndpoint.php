<?php

namespace DCMS\Bundle\RoutingBundle\Entity;
use DCMS\Bundle\RoutingBundle\Routing\EndpointableInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="dcms_test_endpoint")
 */
class TestEndpoint implements EndpointableInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * Note: This field is NOT mapped
     *       It is populated by the EndpointableSubscriber
     */
    protected $endpointPath;

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }
    
    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getEndpointPath()
    {
        return $this->endpointPath;
    }
    
    public function setEndpointPath($endpointPath)
    {
        $this->endpointPath = $endpointPath;
    }
}
