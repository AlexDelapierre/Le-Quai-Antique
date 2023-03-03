<?php

namespace App\DataFixtures;

use App\Entity\ServiceSoir;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ServiceSoirFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->createHoraire($manager, 19.00);
        $this->createHoraire($manager, 19.15);
        $this->createHoraire($manager, 19.30);
        $this->createHoraire($manager, 19.45);
        $this->createHoraire($manager, 20.00);
        $this->createHoraire($manager, 20.15);
        $this->createHoraire($manager, 20.30);

        $manager->flush();
    }

    public function createHoraire(ObjectManager $manager, $horaire)
    {
        $service = new ServiceSoir();
        $service->setHoraire($horaire);
        $manager->persist($service);

    }
}