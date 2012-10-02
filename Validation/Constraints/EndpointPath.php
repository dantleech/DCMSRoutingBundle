<?php

namespace DCMS\Bundle\RoutingBundle\Validation\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class EndpointPath extends Constraint
{
    public $message = 'This path already exists';
    public $target = null;
    public $field = null;

    public function getRequiredOptions()
    {
        return array('field');
    }

    public function validatedBy()
    {
        return 'dcms_routing.endpoint_path';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}



