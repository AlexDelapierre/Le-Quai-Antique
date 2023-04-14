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
        $this->createPlat('Salade du chef', 'Le poulet, les oeufs, le fromage bleu et l’avocat mûr font de cette succulente salade un plat très nourrissant.', 14, '300X300-4dc7b802487970aeeff0ac1470ae8b96.webp', 1, $manager);
        $this->createPlat('Spaghetti', 'Spaghetti Napoli Pasta al Pomodoro !', 15, '300X300-7a80ce62ad457a1133f9b6b1b1c94216.webp', 2, $manager);
        $this->createPlat('Tiramisu', 'Un super tiramisu', 6, '300X300-c895b63c689b466935e5a516c694fa64.webp', 3, $manager);

        $manager->flush();
    }

    public function createPlat(string $title, string $description, float $price, string $image, int $counterCategory, ObjectManager $manager)
    {
        $plat = new Plat();
        $plat->setTitle($title);
        $plat->setDescription($description);
        $plat->setPrice($price);
        $plat->setImage($image);
        $manager->persist($plat);

        //On va chercher une référence de CatégorieFixtures 
        $category = $this->getReference('cat-'.$counterCategory);
        $plat->setCategory($category);

        #Référence : mis en mémoire sous un nom d'un élément pour GalerieFixtures
        $this->setReference('plat-'.$this->counter, $plat);
        $this->counter++;
        
        return $plat;
    }
}