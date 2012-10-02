<?php

namespace DCMS\Extension\SiteRoutingBundle\Tests\Doctrine;

use DCMS\Bundle\RoutingBundle\Doctrine\EndpointableSubscriber;
use DCMS\Bundle\RoutingBundle\Entity\TestEndpoint;
use DCMS\Bundle\RoutingBundle\Routing\TestEndpointClass;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\ORM\Tools\SchemaTool;

class EndpointableSubscriberTest extends WebTestCase
{
    public function setUp()
    {
        $this->client = static::createClient();
        $this->container = $this->client->getContainer();

        $this->epm = $this->container->get('dcms_routing.endpoint_manager');
        $this->em = $this->container->get('doctrine.orm.entity_manager');
        $this->epRepo = $this->em->getRepository('DCMS\Bundle\RoutingBundle\Entity\Endpoint');
        $this->teRepo = $this->em->getRepository('DCMS\Bundle\RoutingBundle\Entity\TestEndpoint');

        $testEndpointClass = new TestEndpointClass;
        $this->epm->registerEPClass($testEndpointClass);

        // setup db
        $connection = $this->em->getConnection();
        $params = $connection->getParams();
        $name = isset($params['path']) ? $params['path'] : $params['dbname'];
        $st = new SchemaTool($this->em);
        $st->dropDatabase($name);
        $metadatas = $this->em->getMetadataFactory()->getAllMetadata();
        $st->createSchema($metadatas);
    }

    public function testPostPersist()
    {
        $p = new TestEndpoint;
        $p->setTitle('Test');
        $p->setEndpointPath('/thisistestendpointPath');

        $this->em->persist($p);
        $this->em->flush();

        $endpointPath = $this->epRepo->getByPath('/thisistestendpointPath');
        $this->assertNotNull($endpointPath);
    }

    public function testDeleteEntity()
    {
        // Test that deleting the entity also deletes the endpointPath.
        $p = new TestEndpoint;
        $p->setTitle('Page 1');
        $p->setEndpointPath('/thisistestendpointPath');

        $this->em->persist($p);
        $this->em->flush();
        $this->em->clear();

        $p = $this->teRepo->findOneByTitle('Page 1');
        $this->em->remove($p);
        $this->em->flush();

        $endpointPath = $this->epRepo->getByPath('/thisistestendpointPath');
        $this->assertNull($endpointPath);
    }
}
