<?php

namespace DCMS\Bundle\RoutingBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;

class WebTestCase extends BaseWebTestCase
{
    public function getContainer()
    {
        return self::$kernel->getContainer();
    }
}
