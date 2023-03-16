<?php

namespace App\DataFixtures;

use App\Entity\Plat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PlatFixtures extends Fixture
{
    private $counter = 1;

    public function load(ObjectManager $manager): void
    {
        $this->createPlat('Salade du chef', 'Le poulet, les oeufs, le fromage bleu et l’avocat mûr font de cette succulente salade un plat très nourrissant.', 14, 1, $manager);
        $this->createPlat('Spaghetti', 'Spaghetti Napoli Pasta al Pomodoro !', 15, 2, $manager);
        $this->createPlat('Tiramisu', 'Un super tiramisu', 6, 3, $manager);

        $manager->flush();
    }

    public function createPlat(string $title, string $description ,float $price, int $counterCategory,ObjectManager $manager)
    {
        $plat = new Plat();
        $plat->setTitle($title);
        $plat->setDescription($description);
        $plat->setPrice($price);
        $manager->persist($plat);

        //On va chercher une référence de CatégorieFixtures 
        $category = $this->getReference('cat-'.$counterCategory);
        $plat->setCategory($category);

        $this->setReference('plat-'.$this->counter, $plat);
        $this->counter++;
        
        return $plat;
    }
}