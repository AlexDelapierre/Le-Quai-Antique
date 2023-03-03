<?php

namespace App\DataFixtures;

use App\Entity\ConfigSite;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ConfigSiteFixtures extends Fixture
{
    public function load(int $maxCouverts, string $horaires ,ObjectManager $manager): void
    {
        $plat = new ConfigSite();
        $plat->setMaxCouverts($maxCouverts);
        $plat->setHoraires($horaires);
        $manager->persist($plat);

        $manager->flush();
    }
}