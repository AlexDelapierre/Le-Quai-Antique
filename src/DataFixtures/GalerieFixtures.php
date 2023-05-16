<?php

namespace App\DataFixtures;

use App\Entity\Galerie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class GalerieFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $this->createGalerie($manager, 3);
        $this->createGalerie($manager, 5);
        $this->createGalerie($manager, 8);
        

        $manager->flush();
    }

    public function createGalerie(ObjectManager $manager, int $counterImage)
    {
        $galerie = new Galerie();
        //On va chercher une référence de ImageFixtures
        $image = $this->getReference('plat-'.$counterImage);
        $galerie->setPlat($image);

        $manager->persist($galerie);

    }

    //Méthode de la DependentFixtureInterface qui permet de changer l'ordre alphabétique du chargement des fixtures lors d'un data load
    public function getDependencies(): array
    {
        return [
            PlatFixtures::class
        ];
    }
}