<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Faker;

class UserFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordEncoder,
        private SluggerInterface $slugger
     ){}

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setEmail('admin@demo.fr');
        $admin->setLastname('DELAPIERRE');
        $admin->setFirstname('Alexandre');
        $admin->setPhoneNumber('0627175198');
        $admin->setPassword($this->passwordEncoder->hashPassword($admin, 'admin'));
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setNbCouverts(2);
        $admin->setAllergie('Crustacés');
        

        $manager->persist($admin);

        //use the factory to create a Faker\Generator instance
        $faker = Faker\Factory::create('fr_FR');

        for($usr=1; $usr<=5; $usr++){
            $user = new User();
            $user->setEmail($faker->email);
            $user->setLastname($faker->lastName);
            $user->setFirstname($faker->firstName);
            $user->setPhoneNumber($faker->phoneNumber);
            $user->setPassword($this->passwordEncoder->hashPassword($user, 'secret'));

        $manager->persist($user);
        }

        $manager->flush();
    }
}