<?php
namespace Yoda\EventBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Yoda\EventBundle\Entity\Event;


class LoadEvents implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $event = new Event();
        $event->setName('Luke Skywalkers breakfast');
        $event->setLocation('Antooine');
        $event->setTime(new \DateTime('tomorrow noon'));
        $event->setDetails('Ha! May the force be with you!!!');
        $manager->persist($event);

        $event2 = new Event();
        $event2->setName('Yoda\'s speech');
        $event2->setLocation('Dagobah');
        $event2->setTime(new \DateTime('tomorrow noon'));
        $event2->setDetails('Square be or there be!!!');
        $manager->persist($event2);


        $manager->flush();
    }
}