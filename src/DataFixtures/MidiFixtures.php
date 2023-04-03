<?php

namespace App\DataFixtures;

use App\Entity\Midi;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MidiFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->createMidi("12:00:00", $manager);
        $this->createMidi("12:15:00", $manager);
        $this->createMidi("12:30:00", $manager);
        $this->createMidi("12:45:00", $manager);
        $this->createMidi("13:00:00", $manager);
        $this->createMidi("13:15:00", $manager);
        $this->createMidi("13:30:00", $manager);
        $this->createMidi("13:45:00", $manager);
        $this->createMidi("14:00:00", $manager);

        $manager->flush();
    }

    public function createMidi(string $title, ObjectManager $manager)
    {
        $midi = new Midi();
        //Pour convertir une string en objet dateTime :
        $midi->setTime(DateTime::createfromformat('H:i:s',$title));
        $manager->persist($midi);   
    }
}