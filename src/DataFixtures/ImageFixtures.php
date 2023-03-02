<?php

namespace App\DataFixtures;

use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ImageFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $this->createImage('Salade du chef', 'Salade_du_chef.jpg', 1, $manager);
        $this->createImage('Spaghetti', 'Spaghetti.jpg', 2, $manager);
        $this->createImage('Tiramisu', 'Tiramisu.jpg', 3, $manager);  

        $manager->flush();
    }

    public function createImage(string $title, string $filename, int $platCounter, ObjectManager $manager)
    {
        $image = new Image();
        $image->setTitle($title);
        $image->setFilename($filename);
        $plat = $this->getReference('plat-'.$platCounter);
        $image->setPlat($plat);   
        $manager->persist($image);
        
        return $image;
    }

    //Méthode de la DependentFixtureInterface qui permet de changer l'ordre alphabétique du chargement des fixtures lors d'un data load
    public function getDependencies(): array
    {
        return [
            PlatFixtures::class
        ];
    }
}