<?php

namespace App\DataFixtures;

use App\Entity\Soir;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SoirFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->createMidi("19:00:00", $manager);
        $this->createMidi("19:15:00", $manager);
        $this->createMidi("19:30:00", $manager);
        $this->createMidi("19:45:00", $manager);
        $this->createMidi("20:00:00", $manager);
        $this->createMidi("20:15:00", $manager);
        $this->createMidi("20:30:00", $manager);
        $this->createMidi("20:45:00", $manager);
        $this->createMidi("21:00:00", $manager);

        $manager->flush();
    }

    public function createMidi(string $title, ObjectManager $manager)
    {
        $soir = new Soir();
        //Pour convertir une string en objet dateTime :
        $soir->setTime(DateTime::createfromformat('H:i:s',$title));
        $manager->persist($soir);   
    }
}