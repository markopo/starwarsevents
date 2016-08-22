<?php
namespace Yoda\EventBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Yoda\EventBundle\Entity\Event;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;


class LoadEvents implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $marko = $manager->getRepository('UserBundle:User')->findOneByUsernameOrEmail('marko');

        $event = new Event();
        $event->setName('Luke Skywalkers breakfast');
        $event->setLocation('Antooine');
        $event->setTime(new \DateTime('2018-01-08'));
        $event->setDetails('Ha! May the force be with you!!!');
        $manager->persist($event);

        $event2 = new Event();
        $event2->setName('Yoda\'s speech');
        $event2->setLocation('Dagobah');
        $event2->setTime(new \DateTime('tomorrow noon'));
        $event2->setDetails('Square be or there be!!!');
        $manager->persist($event2);

        $event->setOwner($marko);
        $event2->setOwner($marko);

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
       return 20;
    }
}