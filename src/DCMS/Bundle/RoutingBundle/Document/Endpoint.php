<?php

namespace DCMS\Bundle\RoutingBundle\Document;
use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;

/**
 * @PHPCR\Document()
 */
class Endpoint
{
    /** 
     * @PHPCR\Id
     */
    protected $id;

    /** 
     * @PHPCR\ParentDocument
     */
    protected $parent;

    /** 
     * @PHPCR\NodeName
     */
    protected $nodeName;

    /**
     * @PHPCR\String()
     */
    protected $path;

    /**
     * @PHPCR\String()
     */
    protected $epClass;

    /**
     * @PHPCR\String()
     */
    protected $foreignId;

    /**
     * @PHPCR\String(multivalue=true)
     */
    protected $parameters;

    public function getId()
    {
        return $this->id;
    }

    public function getParent()
    {
        return $this->parent;
    }
    
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    public function getNodeName()
    {
        return $this->nodeName;
    }
    
    public function setNodeName($nodeName)
    {
        $this->nodeName = $nodeName;
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
