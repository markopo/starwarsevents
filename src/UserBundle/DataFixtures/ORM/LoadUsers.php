<?php

namespace UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;


class LoadUser implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('marko');
        $user->setPassword($this->encodePassword($user, 'markopass'));
        $user->setRoles(array('ROLE_ADMIN'));
        $manager->persist($user);
        $manager->flush();

        $user = new User();
        $user->setUsername('wayne');
        $user->setPassword($this->encodePassword($user, 'waynepass'));
        $user->setRoles(array('ROLE_ADMIN'));
        $user->setIsActive(false);
        $manager->persist($user);
        $manager->flush();
    }

    private function encodePassword(User $user, $plainPassword) {
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
        return $encoder->encodePassword($plainPassword, $user->getSalt());
    }


    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }


}