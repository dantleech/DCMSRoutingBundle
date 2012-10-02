<?php

namespace DCMS\Bundle\RoutingBundle\Validation\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use DCMS\Bundle\RoutingBundle\Routing\EndpointManager;

class EndpointPathValidator extends ConstraintValidator
{
    protected $epm;

    public function __construct(EndpointManager $epm)
    {
        $this->epm = $epm;
    }

    public function isValid($entity, Constraint $constraint)
    {
        if (!$constraint->field) {
            throw new ConstraintDefinitionException('You must define a "field"');
        }

        $field = $constraint->field;
        $handlerKey = $this->epm->getEPClassForEntity($entity)->getKey();

        // get the epPath value
        // we do not know the get/set method, and it is probably private or protected
        // so use Reflection to get the value.
        
        $refl = new \ReflectionClass($entity);
        $prop = $refl->getProperty($field);
        $prop->setAccessible(true);
        if (!$prop) {
            throw new ConstraintDefinitionException('Cannot read property "'.$field.'" from class');
        }
        $epPath = $prop->getValue($entity);

        $site = $this->sm->getSite();

        $endpoint = $this->epm->getEndpointByPath($epPath);

        if ($endpoint) {
            // if the epPath is for this entity, then OK.
            if ($handlerKey == $endpoint->getEPClass() && $endpoint->getForeignId() == $entity->getId()) {
                return true;
            }
        }

        if (!$epPath) {
            return true;
        }

        if ($constraint->target) {
            $field = $constraint->target;
        }

        $oldPath = $this->context->getPropertyPath();
        $this->context->setPropertyPath(empty($oldPath) ? $field : $oldPath.".".$field);
        $this->context->addViolation($constraint->message, array(), $epPath->getRoute());
        $this->context->setPropertyPath($oldPath);

        return true; // already added violation..
    }
}
