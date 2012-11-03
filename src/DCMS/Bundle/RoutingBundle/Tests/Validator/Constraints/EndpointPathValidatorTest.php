<?php

namespace DCMS\Bundle\RoutingBundle\Tests\Validator\Constraints;

use DCMS\Bundle\RoutingBundle\Tests\WebTestCase;
use DCMS\Bundle\RoutingBundle\Document\Endpoint;

class EndpointPathValidatorTest extends WebTestCase
{
    protected function loadFixtures()
    {
        $this->ep1 = new Endpoint;
        $this->ep1->setPath('/test/ep1');
        $this->ep1->setNodeName('endpoint 1');
        $this->ep1->setParent($this->root);
        $this->dm->persist($this->ep1);
        $this->ep2 = new Endpoint;
        $this->ep2->setPath('/test/ep2');
        $this->ep2->setNodeName('endpoint 2');
        $this->ep2->setParent($this->root);
        $this->dm->persist($this->ep2);
        $this->dm->flush();
    }

    public function setUp()
    {
        $this->client = $this->createClient();
        $this->validator = $this->getContainer()->get('validator');
        $this->epm = $this->getContainer()->get('dcms_routing.endpoint_manager');
        $this->dm = $this->getContainer()->get('doctrine_phpcr.odm.document_manager');

        $session = $this->dm->getPhpcrSession();
        $rNode = $session->getNode('/');
        if ($rNode->hasNode('test')) {
            $rNode->getNode('test')->remove();
            $session->save();
        }
        $rNode->addNode('test');
        $session->save();
        $this->root = $this->dm->find(null, '/test');

        $this->loadFixtures();
    }

    public function testNewEndpoint()
    {
        $ep = new Endpoint;
        $ep->setPath('/test/noexisting');
        $ep->setNodeName('foobar');
        $violations = $this->validator->validate($ep);
        $this->assertEquals(0, count($violations));
    }

    public function testNewEndpointExistingRoute()
    {
        $ep = new Endpoint;
        $ep->setPath('/test/ep1');
        $ep->setNodeName('foobar');
        $violations = $this->validator->validate($ep);
        $this->assertEquals(1, count($violations));
    }

    public function testExistingEndpoint()
    {
        $r = new Endpoint;
        $r->setPath('/test/hello');
        $r->setNodeName('foo');
        $r->setParent($this->root);
        $this->dm->persist($r);
        $this->dm->flush();
        $this->dm->clear();

        $r = $this->dm->find(null, '/test/foo');

        $violations = $this->validator->validate($r);
        $this->assertEquals(0, count($violations));
    }
}
