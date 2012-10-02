<?php

namespace DCMS\Bundle\RoutingBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="DCMS\Bundle\RoutingBundle\Repository\EndpointRepository")
 * @ORM\Table(name="dcms_endpoint")
 */
class Endpoint
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
    protected $path;

    /**
     * @ORM\Column(type="string")
     */
    protected $epClass;

    /**
     * @ORM\Column(type="integer")
     */
    protected $foreignId;

    /**
     * @ORM\Column(type="array")
     */
    protected $parameters;

    public function getId()
    {
        return $this->id;
    }

    public function getPath()
    {
        return $this->path;
    }
    
    public function setPath($path)
    {
        $this->path = $path;
    }

    public function getEpClass()
    {
        return $this->epClass;
    }
    
    public function setEpClass($epClass)
    {
        $this->epClass = $epClass;
    }

    public function getParameters()
    {
        return $this->parameters;
    }
    
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
    }

    public function getForeignId()
    {
        return $this->foreignId;
    }
    
    public function setForeignId($foreignId)
    {
        $this->foreignId = $foreignId;
    }
}
