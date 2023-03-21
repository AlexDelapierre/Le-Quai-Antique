<?php

namespace App\DataFixtures;

use App\Entity\Horaire;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HoraireFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $monday = '12:00 - 14:00<br>19:00 - 22:00';
        $tuesday = '12:00 - 14:00<br>19:00 - 22:00';
        $wednesday = 'fermé';
        $thursday = '12:00 - 14:00<br>19:00 - 22:00';
        $friday = '12:00 - 14:00<br>19:00 - 22:00';
        $saturday = '12:00 - 14:00<br>19:00 - 23:00';
        $sunday = 'fermé';

        $horaire = new Horaire();
        $horaire->setMonday($monday);
        $horaire->setTuesday($tuesday);
        $horaire->setWednesday($wednesday);
        $horaire->setThursday($thursday);
        $horaire->setFriday($friday);
        $horaire->setSaturday($saturday);
        $horaire->setSunday($sunday);

        $manager->persist($horaire);
        $manager->flush();
    }
}