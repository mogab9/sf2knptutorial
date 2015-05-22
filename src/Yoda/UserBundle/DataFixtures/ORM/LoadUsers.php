<?php

namespace Yoda\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Yoda\UserBundle\Entity\User;

class LoadUsers implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $_container;

    /**
    * {@inheritDoc}
    */
    public function load(ObjectManager $manager)
    {
        $user = new User();

        $user->setUsername('darth');
        $user->setEmail('darth@deathstar.com');
        $user->setPassword($this->_encodePassword($user, 'darthpass'));
        $manager->persist($user);

        $admin = new User();
        $admin->setUsername('wayne');
        $admin->setEmail('wayne@deathstar.com');
        $admin->setPassword($this->_encodePassword($admin, 'waynepass'));
        $admin->setRoles(array('ROLE_ADMIN'));
        //$admin->setIsActive(false);
        $manager->persist($admin);

        $manager->flush();
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->_container = $container;
    }

    private function _encodePassword(User $user, $plainPassword)
    {
        $encoder = $this->_container->get('security.encoder_factory')->getEncoder($user);
        return $encoder->encodePassword($plainPassword, $user->getSalt());
    }
}