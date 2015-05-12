<?php

namespace Yoda\EventBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Yoda\EventBundle\Entity\Event;

class LoadEvents implements FixtureInterface
{
    /**
    * {@inheritDoc}
    */
    public function load(ObjectManager $manager)
    {
        $event1 = new Event();
        $event1->setName('Sample Name');
        $event1->setLocation('Sample Location');
        $event1->setTime(new \DateTime('12-12-2020 12:30:00'));
        $event1->setDetails('Sample Details');
        $manager->persist($event1);

        $event2 = new Event();
        $event2->setName('Sample Name 2');
        $event2->setLocation('Sample Location 2');
        $event2->setTime(new \DateTime('03-03-2021 11:00:00'));
        $event2->setDetails('Sample Details 2');
        $manager->persist($event2);

        $manager->flush();
    }
}