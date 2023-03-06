<?php

namespace App\DataFixtures;

use App\Entity\ServiceMidi;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ServiceMidiFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $this->createHoraire($manager, );
        // $this->createHoraire($manager, );
        // $this->createHoraire($manager, );
        // $this->createHoraire($manager, );
        // $this->createHoraire($manager, );
        // $this->createHoraire($manager, );
        // $this->createHoraire($manager, );

        $manager->flush();
    }

    public function createHoraire(ObjectManager $manager, $creneau)
    {
        $service = new ServiceMidi();
        $service->setHoraire($creneau);
        $manager->persist($service);

    }
}