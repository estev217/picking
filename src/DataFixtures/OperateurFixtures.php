<?php

namespace App\DataFixtures;

use App\Entity\Operateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;

class OperateurFixtures extends Fixture implements DependentFixtureInterface
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $admin = new Operateur();
        $admin->setUsername('efernandes');
        $admin->setPassword($this->passwordEncoder->encodePassword(
            $admin,
            'admin'
        ));
        $admin->setRole($this->getReference('role_0'));
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);
        $this->addReference('admin', $admin);

        $user = new Operateur();
        $user->setUsername('plambda');
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'user'
        ));
        $user->setRole($this->getReference('role_1'));
        $user->setRoles(['ROLE_OPERATEUR']);
        $manager->persist($user);
        $this->addReference('user', $user);

        $inactive = new Operateur();
        $inactive->setUsername('pinactive');
        $inactive->setPassword($this->passwordEncoder->encodePassword(
            $inactive,
            'inactive'
        ));
        $inactive->setRole($this->getReference('role_2'));
        $inactive->setRoles(['ROLE_INACTIF']);
        $manager->persist($inactive);
        $this->addReference('inactif', $inactive);

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [RoleFixtures::class];
    }
}
