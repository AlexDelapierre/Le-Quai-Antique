<?php

namespace App\DataFixtures;

use App\Entity\Couvert;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CouvertFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $couvert = new Couvert();
        $couvert->setMaxCouverts(20);
        $manager->persist($couvert);

        $manager->flush();
    }
}