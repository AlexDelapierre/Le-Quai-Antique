<?php

namespace App\DataFixtures;

use App\Entity\Formule;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class FormuleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $this->createFormule($manager, 'Formule déjeuner', 
        '(Le midi du lundi au vendredi) <br> Entrée + plat ou plat + dessert', 16.00, 1);
        $this->createFormule($manager, 'Formule dîner', 
        '(Le soir du lundi au samedi) <br> Entrée + plat + dessert', 20.00, 1);

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

    //Méthode de la DependentFixtureInterface qui permet de changer l'ordre alphabétique du chargement des fixtures lors d'un data load
    public function getDependencies(): array
    {
        return [
            MenuFixtures::class
        ];
    }
}