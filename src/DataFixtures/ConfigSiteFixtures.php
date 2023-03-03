<?php

namespace App\DataFixtures;

use App\Entity\ConfigSite;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ConfigSiteFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $horaires = '';
        $plat = new ConfigSite();
        $plat->setMaxCouverts(20);
        $plat->setHoraires($horaires);
        $manager->persist($plat);

        $manager->flush();
    }
}