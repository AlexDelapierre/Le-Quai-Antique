<?php

namespace App\DataFixtures;

use App\Entity\ServiceMidi;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ServiceMidiFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->createHoraire($manager, 12.00);
        $this->createHoraire($manager, 12.15);
        $this->createHoraire($manager, 12.30);
        $this->createHoraire($manager, 12.45);
        $this->createHoraire($manager, 13.00);
        $this->createHoraire($manager, 13.15);
        $this->createHoraire($manager, 13.30);

        $manager->flush();
    }

    public function createHoraire(ObjectManager $manager, $horaire)
    {
        $service = new ServiceMidi();
        $service->setHoraire($horaire);
        $manager->persist($service);

    }
}