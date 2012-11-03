<?php

namespace Ylly\Extension\SiteRoutingBundle\Tests\Validator\Constraints;
use Ylly\CmsBundle\Test\WebTestCase;
use Ylly\CmsBundle\Entity\Page;

class SiteRouteValidatorTest extends WebTestCase
{
    public function setUp()
    {
        $this->validator = $this->getContainer()->get('validator');
        $this->epm = $this->getContainer()->get('dcms_routing.endpoint_manager');
        $this->dm = $this->getContainer()->get('doctrine_phpcr.odm.document_manager');
    }

    public function testNewEntityNoExistingRoute()
    {
        $page = new Page;
        $page->setRoute('/noexisting');
        $page->setTitle('foobar');
        $violations = $this->validator->validate($page);
        $this->assertEquals(0, count($violations));
    }

    public function testNewEntityExistingRoute()
    {
        $page = new Page;
        $page->setRoute('/page1');
        $page->setTitle('foobar');
        $violations = $this->validator->validate($page);
        $this->assertEquals(1, count($violations));
    }

    public function testSameEntityExistingRoute()
    {
        $r = $this->srm->getRouteForEntity($this->site, $this->page1);
        $r->setRoute('/hello');
        $this->em->persist($r);
        $this->em->flush();
        $this->em->clear();

        $this->page1->setRoute('/hello');

        $violations = $this->validator->validate($this->page1);
        $this->assertEquals(0, count($violations));
    }

    public function testExistingEntityExistingRoute()
    {
        // the route page1 exists
        $this->page2->setRoute('/page1');

        $violations = $this->validator->validate($this->page2);
        $this->assertEquals(1, count($violations));
    }


    public function testExistingEntityNonExistingRoute()
    {
        $this->setSite(1);

        // the route page1 exists
        $this->page2->setRoute('/pageasdasd-does-not-exist');

        $violations = $this->validator->validate($this->page2);
        $this->assertEquals(0, count($violations));
    }
}
