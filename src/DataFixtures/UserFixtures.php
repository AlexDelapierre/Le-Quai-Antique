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