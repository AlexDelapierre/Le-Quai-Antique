<?php

namespace App\DataFixtures;

use App\Entity\Formule;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FormuleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->createFormule($manager, 'Formule déjeuner', '', 16.00, 1);
        $this->createFormule($manager, 'Formule déjeuner', '', 16.00, 1);

        $manager->flush();
    }

    public function createFormule(ObjectManager $manager, string $name, string $description, float $price, int $menuCounter)
    {
        $formule = new Formule();
        $formule->setName($name);
        $formule->setDescription($description);
        $formule->setPrice($price);

        //On va chercher une référence de menu
        $menu = $this->getReference('menu-'.$menuCounter);
        $formule->setMenu($menu);

        $manager->persist($formule);
    }
}